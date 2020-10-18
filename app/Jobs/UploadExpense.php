<?php

namespace App\Jobs;

use Ajaxray\PHPWatermark\Watermark;
use App\CustomOption;
use App\Expense;
use App\Http\Controllers\GoogleDriveController;
use App\Mail\FailedExpenseUploadJob;
use App\User;
use Exception;
use Google_Service_Drive_DriveFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use NMC\ImageWithText\Image;
use NMC\ImageWithText\Text;
use setasign\Fpdi\Fpdi;

class UploadExpense implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $expense;

    /**
     * Create a new job instance.
     *
     * @param Expense $expense
     */
    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $file = 'public/' . $this->expense->file_path;
        $name = $this->expense->ph_id . "." . File::extension($file);

        $metadata = new Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'parents' => explode(",", CustomOption::get('DRIVE_EXPENSE_PARENT'))
        ));

        $extensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if (in_array(File::extension(Storage::path($file)), $extensions, false)) {
            $this->addTextToImage($file);
        }

        if (File::extension(Storage::path($file)) == 'pdf') {
            $this->addTexToPdf($file);
        }


        $this->expense = $this->expense->fresh();
        $file = 'public/' . $this->expense->file_path;

        GoogleDriveController::createFile($metadata, array(
            'data' => Storage::get($file),
            'mimeType' => File::mimeType(Storage::path($file)),
            'uploadType' => 'multipart'
        ));

        $this->expense->uploaded = true;
        $this->expense->save();
    }

    private function addTextToImage($file)
    {
        $path = Storage::path($file);
        $image = new Image($path);

        $width = $image->getWidth();

        $text = new Text('Bilagsnr.: ' . $this->expense->ph_id);
        $text->size = 2 * ($width / 72);
        $text->font = Storage::path('public/OpenSans-Regular.ttf');
        $text->color = 'ff0000';
        $text->startX = 5;
        $text->startY = 2 * ($width / 72);

        $image->addText($text);

        $updatedPath = File::dirname($path) . "/" . File::name($path) . '-uploaded.' . File::extension($path);

        $image->render($updatedPath);

        $this->expense->file_path = "expenses/" . File::name($path) . '-uploaded.' . File::extension($path);
        $this->expense->save();


    }

    private function addTexToPdf($file)
    {
        $path = Storage::path($file);

        // Create instance and get the source file
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($path);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {

            $tplId = $pdf->importPage($pageNo);
            $pdf->AddPage();
            $pdf->useTemplate($tplId, ['adjustPageSize' => true]);

            $pdf->setFont('Helvetica');
            $pdf->setTextColor(255, 0, 0);
            $pdf->setFontSize(18);
            $pdf->setXY(0,0);
            $pdf->Write(12, 'Bilagsnr.: ' . $this->expense->ph_id);

        }

        $updatedPath = File::dirname($path) . "/" . File::name($path) . '-uploaded.' . File::extension($path);

        $pdf->Output('F', $updatedPath);

        $this->expense->file_path = "expenses/" . File::name($path) . '-uploaded.' . File::extension($path);
        $this->expense->save();


    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     */
    public function failed(Exception $exception)
    {
        // TODO Refactor to use nicer method to get admins
        foreach (User::all() as $user) {
            if ($user->isAdmin()) {
                Mail::to($user->email)->send(new FailedExpenseUploadJob($this->expense, $exception));
            }
        }
    }
}

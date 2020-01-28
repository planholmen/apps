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
        $name = $this->expense->ph_id . " - " . $this->expense->department . " " . $this->expense->activity . " - " . $this->expense->creditor . "." . File::extension($file);

        $metadata = new Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'parents' => explode(",", CustomOption::get('DRIVE_EXPENSE_PARENT'))
        ));

        $extensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if (in_array(File::extension(Storage::path($file)), $extensions, false)) {
            $this->addTextToImage($file);
        }

        if (File::extension(Storage::get($file)) == 'pdf') {
            $this->addTexToPdf($file);
        }

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
        $text = new Text('Bilagsnr.: ' . $this->expense->ph_id);
        $text->size = 20;
        $text->font = '/usr/share/fonts/truetype/dejavu/DejaVuSerif.ttf';
        $text->startX = 5;
        $text->startY = 5;

        $image = new Image(Storage::path($file));
        $image->addText($text);
        $image->render(Storage::path($file));
    }

    private function addTexToPdf($file)
    {
        // TODO Add image to pdf files
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     */
    public function failed(Exception $exception)
    {
        foreach (User::all() as $user) {
            if ($user->isAdmin()) {
                Mail::to($user->email)->send(new FailedExpenseUploadJob($this->expense, $exception));
            }
        }
    }
}

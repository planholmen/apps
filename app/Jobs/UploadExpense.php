<?php

namespace App\Jobs;

use App\Expense;
use App\Http\Controllers\GoogleDriveController;
use App\Mail\FailedExpenseUploadJob;
use App\User;
use Google_Service_Drive_DriveFile;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
            'parents' => explode(",", env('DRIVE_EXPENSE_PARENT'))
        ));

        $content = Storage::get($file);

        GoogleDriveController::createFile($metadata, array(
            'data' => $content,
            'mimeType' => File::mimeType(Storage::path($file)),
            'uploadType' => 'multipart'
        ));

        $this->expense->uploaded = true;
        $this->expense->save();
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

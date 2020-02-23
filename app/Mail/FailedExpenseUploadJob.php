<?php

namespace App\Mail;

use App\Expense;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailedExpenseUploadJob extends Mailable
{
    use Queueable, SerializesModels;

    private $expense;
    private $exception;

    /**
     * Create a new message instance.
     *
     * @param Expense $expense
     * @param \Exception $exception
     */
    public function __construct(Expense $expense, Exception $exception)
    {
        $this->expense = $expense;
        $this->exception = $exception;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $expense = $this->expense;
        $exception = $this->exception;

        return $this->from('it@planholmen.dk', config('app.name'))
                    ->subject('Upload af bilag ' . $expense->ph_id . ' fejlet')
                    ->markdown('mails.jobs.expense.failed', compact('expense', 'exception'));
    }
}

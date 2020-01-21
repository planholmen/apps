<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeclineExpense extends Mailable
{
    use Queueable, SerializesModels;

    private $expense;

    /**
     * Create a new message instance.
     *
     * @param $expense
     */
    public function __construct($expense)
    {
        $this->expense = $expense;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $expense = $this->expense;

        return $this->from('it@planholmen.dk')
                    ->subject('Et af dine bilag er blevet afvist')
                    ->markdown('mails.expense.declined', compact('expense'));
    }
}

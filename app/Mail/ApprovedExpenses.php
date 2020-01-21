<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovedExpenses extends Mailable
{
    use Queueable, SerializesModels;

    private $expenses, $user;

    /**
     * Create a new message instance.
     *
     * @param $expenses
     * @param $user
     */
    public function __construct($expenses, $user)
    {
        $this->expenses = $expenses;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $expenses = $this->expenses;
        $user = $this->user;

        return $this->from('it@planholmen.dk')
                    ->replyTo('penge@planholmen.dk', 'PLan Holmen Kasseren')
                    ->subject('Du har fået godkendt bilag!')
                    ->markdown('mails.expense.approved', compact('expenses', 'user'));
    }
}

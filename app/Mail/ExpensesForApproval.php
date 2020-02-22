<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpensesForApproval extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $count;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param int $count
     */
    public function __construct(User $user, int $count)
    {
        $this->user = $user;
        $this->count = $count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $count = $this->count;

        return $this->from('it@planholmen.dk', config('app.name'))
                    ->subject('Der er bilag, der venter på godkendelse')
                    ->markdown('mails.expense.forapproval', compact('user', 'count'));
    }
}

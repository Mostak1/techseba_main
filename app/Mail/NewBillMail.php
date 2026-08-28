<?php

namespace App\Mail;

use App\Models\WorkOrderBill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBillMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;
    public $mail_subject;

    /**
     * Create a new message instance.
     */
    public function __construct(WorkOrderBill $bill, $mail_subject)
    {
        $this->bill = $bill;
        $this->mail_subject = $mail_subject;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->mail_subject)
                    ->view('emails.new_bill');
    }
}

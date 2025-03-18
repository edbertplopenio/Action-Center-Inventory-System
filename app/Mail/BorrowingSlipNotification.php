<?php

namespace App\Mail;

use App\Models\BorrowingSlip;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorrowingSlipNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $borrowingSlip;

    /**
     * Create a new message instance.
     *
     * @param BorrowingSlip $borrowingSlip
     * @return void
     */
    public function __construct(BorrowingSlip $borrowingSlip)
    {
        $this->borrowingSlip = $borrowingSlip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.borrowing-slip-notification')
                    ->subject('New Borrowing Slip for Approval')
                    ->with([
                        'borrowingSlip' => $this->borrowingSlip,
                    ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorrowingSlipApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $borrower;
    public $borrowingSlip;

    public function __construct($borrower, $borrowingSlip)
    {
        $this->borrower = $borrower;
        $this->borrowingSlip = $borrowingSlip;
    }

    public function build()
    {
        return $this->subject('Your Borrowing Slip Has Been Approved')
                    ->view('emails.borrowing-slip-approved')
                    ->with([
                        'borrower' => $this->borrower,
                        'borrowingSlip' => $this->borrowingSlip,
                    ]);
    }
}

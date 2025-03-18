<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorrowingSlipSubmitted extends Mailable
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
        return $this->subject('Borrowing Slip Submission Confirmation')
                    ->view('emails.borrowing-slip-submitted')
                    ->with([
                        'borrower' => $this->borrower,
                        'borrowingSlip' => $this->borrowingSlip,
                    ]);
    }
}

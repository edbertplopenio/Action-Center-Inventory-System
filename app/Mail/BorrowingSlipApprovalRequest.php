<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorrowingSlipApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $approver;
    public $borrowingSlip;

    public function __construct($approver, $borrowingSlip)
    {
        $this->approver = $approver;
        $this->borrowingSlip = $borrowingSlip;
    }

    public function build()
    {
        return $this->subject('New Borrowing Slip Approval Request')
                    ->view('emails.borrowing-slip-approval')
                    ->with([
                        'approver' => $this->approver,
                        'borrowingSlip' => $this->borrowingSlip,
                    ]);
    }
}

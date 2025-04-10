<?php

namespace App\Events;

use App\Models\BorrowedItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BorrowingRequestCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $borrowedItem;

    public function __construct(BorrowedItem $borrowedItem)
    {
        $this->borrowedItem = $borrowedItem;
    }

    public function broadcastOn()
    {
        return new Channel('borrowing-requests');
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendTransactionCoin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $team;
    public $balance;
    public $coin;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($team, $balance, $coin)
    {
        $this->team = $team;
        $this->balance = $balance;
        $this->coin = $coin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('send-transaction.'.$this->team);
    }

    public function broadcastAs() 
    {
        return 'transaction';
    }
}

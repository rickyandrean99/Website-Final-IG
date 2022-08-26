<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatePreparation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $team;
    public $profit;
    public $market_share;
    public $rent_price;
    public $balance;

    public function __construct($team, $profit, $market_share, $rent_price, $balance)
    {
        $this->team = $team;
        $this->profit = $profit;
        $this->market_share = $market_share;
        $this->rent_price = $rent_price;
        $this->balance = $balance;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('update-preparation.'.$this->team);
    }

    public function broadcastAs() {
        return "preparation";
    }
}

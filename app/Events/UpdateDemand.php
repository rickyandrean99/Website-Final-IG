<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateDemand implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $demands;
    public $price;
    public $batch;
    public $new_timer;
    public $preparation;

    public function __construct($demands, $batch, $price, $new_timer, $preparation)
    {
        $this->demands = $demands;
        $this->batch = $batch;
        $this->price = $price;
        $this->new_timer = $new_timer;
        $this->preparation = $preparation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('update-demand');
    }

    public function broadcastAs() 
    {
        return 'update';
    }
}

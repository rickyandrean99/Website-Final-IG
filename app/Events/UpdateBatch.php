<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateBatch implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $batch;
    public $balance;
    public $team;
    public $limit;
    public $ongkir;

    public function __construct($team,$batch, $balance, $limit, $ongkir)
    {
        $this->team = $team;
        $this->batch = $batch;
        $this->balance = $balance;
        $this->limit = $limit;
        $this->ongkir = $ongkir;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('update-batch'.$this->team);
    }

    public function broadcastAs() 
    {
        return 'update';
    }
}

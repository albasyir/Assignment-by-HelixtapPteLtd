<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;

class ExampleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $channel_token;

    public $updated;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channel_token, $updated)
    {
        $this->updated = $updated;
        $this->channel_token = $channel_token;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("plaid.{$this->channel_token}");
    }

    public function broadcastAs()
    {
        return 'UpdateExample';
    }
}

<?php

namespace App\Events\LiveStream;

use App\Models\LiveStream;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BanUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $livestream;

    public $profileId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LiveStream $livestream, $profileId)
    {
        $this->livestream = $livestream;
        $this->profileId = $profileId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): array
    {
        return new Channel('live.chat.'.$this->livestream->profile_id);
    }

    public function broadcastAs()
    {
        return 'chat.ban-user';
    }

    public function broadcastWith()
    {
        return ['id' => $this->profileId];
    }
}

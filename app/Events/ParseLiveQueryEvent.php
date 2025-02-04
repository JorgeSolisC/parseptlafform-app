<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ParseLiveQueryEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $data;

    // Pass the data you want to send to the frontend
    public function __construct($data)
    {
        $this->data = $data;
        Log::info($data);
    }

    // Define the broadcast channel (you can use private or public channels)
    public function broadcastOn()
    {
        return new Channel('dashboard');
    }

    // Customize the broadcast event name if needed
    public function broadcastAs()
    {
        return 'parse-updated';
    }
}

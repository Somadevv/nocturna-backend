<?php

namespace App\Events;

use App\Http\Resources\PlayerResource;
use App\Models\Player;
use Illuminate\Auth\Events\Login;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendLoginResponse
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(Login $event)

    {
        $response = [
            'player' => new PlayerResource(Auth::user()),
        ];
        try {
            return response()->json($response);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}

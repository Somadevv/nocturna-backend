<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerTitleController extends Controller
{

    public function index()
    {
        $player = Player::find(Auth::id());

        return response()->json($player);
    }
    public function create(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'player_id' => 'required|exists:players,id',
            'title' => 'required|string|unique:titles',
        ]);

        $player = Player::find($validatedData['player_id']);

        // Create a new PlayerTitle instance
        $playerTitle = $player->titles()->create(['title' => $validatedData['title']]);

        // Respond appropriately, you may return a response or redirect as needed
        return response()->json(['message' => 'Player title added successfully', 'data' => $playerTitle]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Http\Services\PlayerTitleService;
use App\Models\Player;
use App\Models\Title;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function grantTitle(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'title' => 'required|string|min:2',
        ]);

        // Find the player
        $player = Player::find(Auth::id());

        $titleService = new PlayerTitleService();

        try {
            // Grant the title using the service
            $titleService->grantTitle($player, $request->title);

            // Success response
            $responseMessage = 'Added ' . $request->title . ' title to ' . $player->username;
            return response()->json(['success' => true, 'message' => $responseMessage]);
        } catch (\InvalidArgumentException $e) {
            // Handle invalid argument exception (title not found)
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }



    public function changeActiveTitle(int $titleId)
    {
        $player = Player::find(Auth::id());
        $player->setActiveTitle($titleId);
        $player->save();

        return response()->json(new PlayerResource($player));
    }

    public function show()
    {
        $player = Player::with(['titles', 'activeTitle'])->find(Auth::id());

        return response()->json(new PlayerResource($player));
    }
}

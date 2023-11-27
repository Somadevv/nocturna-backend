<?php

namespace App\Http\Controllers;


use App\Http\Resources\Titles\TitlesResourceCollection;
use App\Http\Services\PlayerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;




class PlayerController extends Controller
{
    public function __construct(private PlayerService $playerService)
    {
    }


    public function grantTitle(Request $request)
    {
        $response = $this->playerService->grantTitle(
            $request->user(),
            $request->get('title')
        );

        return response()->json($response);
    }

    public function setActiveTitle(Request $request)
    {
        $response = $this->playerService->setActiveTitle(
            $request->user(),
            $request->get('title')
        );

        return response()->json($response);
    }


    // PlayerController.php

    public function getProfile(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $player = Auth::guard('api')->user();

            if (!$player) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $profile = $this->playerService->getProfile($player);

            return response()->json($profile);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function getUnlockedTitles(Request $request)
    {
        $player = Auth::user();
        $unlockedTitles = new TitlesResourceCollection($player->unlockedTitles);

        return response()->json(['unlockedTitles' => $unlockedTitles]);
    }

    public function getActiveTitle(Request $request)
    {
        $player = Auth::user();
        $response = $this->playerService->getActiveTitle($player);

        return response()->json($response);
    }
}

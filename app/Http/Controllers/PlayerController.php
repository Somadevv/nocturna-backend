<?php

namespace App\Http\Controllers;

use App\Http\Services\PlayerService;
use App\Http\Services\TitleService;
use Illuminate\Http\Request;


class PlayerController extends Controller
{
    public function __construct(private PlayerService $playerService, private TitleService $titleService)
    {
    }


    public function getProfile(Request $request)
    {
        $player = $request->user();

        try {
            $profile = $this->playerService->getProfile($player);

            return response()->json($profile);
        } catch (\Exception $e) {
            return response()->json(['error' => 'something wrong'], 500);
        }
    }
}

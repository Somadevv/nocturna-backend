<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Http\Resources\Titles\TitlesResourceCollection;
use App\Http\Services\PlayerTitleService;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    private $titleService;
    private $player;
    // global $player could cause issues with request lifecycle
    public function __construct(PlayerTitleService $titleService)
    {
        $this->titleService = $titleService;
        $this->middleware(function ($request, $next) {
            $this->player = Player::find(Auth::id());

            return $next($request);
        });
        // $this->player = Player::find(Auth::id());
    }

    public function grantTitle(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|min:2',
        ]);

        $this->titleService->grantTitle($this->player, $validatedData['title']);

        $responseMessage = "Added {$validatedData['title']} title to {$this->player->username}";

        return response()->json(['success' => true, 'message' => $responseMessage]);
    }

    public function setActiveTitle(Request $request)
    {
        $response = $this->titleService->setActiveTitle($this->player, $request->title);

        return response()->json($response);
    }

    public function getProfile()
    {
        $player = Player::with(['titles', 'activeTitle'])->find(Auth::id());

        return response()->json(new PlayerResource($player));
    }

    public function getUnlockedTitles()
    {
        $unlockedTitles = new TitlesResourceCollection($this->player->unlockedTitles);

        return response()->json(['unlockedTitles' => $unlockedTitles]);
    }

    public function getActiveTitle()
    {
        $response = $this->titleService->getActiveTitle($this->player);

        return response()->json($response);
    }
}

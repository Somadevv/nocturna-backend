<?php

namespace App\Http\Controllers;

use App\Http\Resources\Titles\TitlesResourceCollection;
use App\Http\Services\PlayerService;
use App\Http\Services\TitleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{

    public function __construct(private TitleService $titleService)
    {
    }
    public function getUnlockedTitles(Request $request)
    {
        $player = $request->user();
        $unlockedTitles = new TitlesResourceCollection($player->unlockedTitles);
        $unlockedTitlesCount = $unlockedTitles->count();

        return response()->json(['titles' => [
            "total" => $unlockedTitlesCount,
            "unlocked" => $unlockedTitles->map(function ($title) {
                return ['title' => $title->title];
            })

        ]]);
    }
    // EXAMPLE
    public function grantTitle(Request $request)
    {
        $player = $request->user();
        $title = $request->input('title');

        return $this->titleService->grantTitle($player, $title);
    }
    public function getActiveTitle(Request $request)
    {
        try {
            $this->titleService->getActiveTitle($request->user());
            return response()->json('title added');
        } catch (\Exception $e) {
            return response()->json(['error' => 'error message']);
        }
    }
}

<?php

namespace App\Http\Services;

use App\Models\Player;
use App\Models\Title;

class TitleService
{
    public function setActiveTitle(Player $player, string $titleName)
    {
        $title = $player->titles()->whereName($titleName)->firstOrFail();
        $player->active_title_id = $title->id;
        $player->save();

        return response("Title granted", 200);
    }



    public function grantTitle(Player $player, $title)
    {
        // Check if the title exists
        $titleModel = Title::where('title', $title)->first();

        if (!$titleModel) {
            return response()->json(['error' => 'Title does not exist'], 404);
        }

        // Check if the player already has the title
        if ($player->titles->contains($titleModel)) {
            return response()->json(['error' => 'Player already has this title'], 400);
        }

        // Attach the title to the player
        $player->titles()->attach($titleModel);

        // Return a success response or any other necessary information
        return response()->json(['success' => true, 'message' => 'Title granted'], 200);
    }

    public function getActiveTitle(Player $player)
    {
        return [
            "titleId" =>  $player->activeTitle->id,
            "activeTitle" => $player->activeTitle->title
        ];
    }
}

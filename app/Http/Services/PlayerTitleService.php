<?php

namespace App\Http\Services;

use App\Models\Player;
use App\Models\Title;
use Illuminate\Support\Facades\Auth;

class PlayerTitleService
{

    public function setActiveTitle(Player $player, $title)
    {
        // Check if the title exists
        $titleModel = Title::where('title', $title)->first();

        if (!$titleModel) {
            throw new \InvalidArgumentException("Title does not exist");
        }

        $player = Player::find(Auth::id());

        // Check if the player has unlocked the title
        if (!$player->titles->contains($titleModel)) {
            throw new \InvalidArgumentException("Player has not unlocked the title");
        }

        // Check if the current active title is the same as the incoming title
        if ($player->activeTitle && $player->activeTitle->title === $title) {
            throw new \InvalidArgumentException("Title is already the active title");
        }

        // Set the active title by ID
        $player->active_title_id = $titleModel->id;
        $player->save();

        return response()->json([
            'success' => true,
            'message' => 'Active title assigned',
        ]);
    }


    public function grantTitle(Player $player, $title)
    {
        $player = Player::find(Auth::id());

        // Check if the title exists in the database
        $titleModel = Title::where('title', $title)->first();

        if (!$titleModel) {
            // Title doesn't exist, throw an exception or handle accordingly
            throw new \InvalidArgumentException("Title does not exist");
        }

        // Check if the player already has the title
        if ($player->titles->contains($titleModel)) {
            throw new \InvalidArgumentException("The player already owns the title {$title}!!");
        }

        $player->titles()->syncWithoutDetaching([$titleModel->id]);
    }


    public function getActiveTitle(Player $player)
    {
        return [
            "titleId" =>  $player->activeTitle->id,
            "activeTitle" => $player->activeTitle->title
        ];
    }
}

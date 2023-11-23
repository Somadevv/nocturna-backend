<?php

namespace App\Http\Services;

use App\Models\Player;
use App\Models\Title;
use Illuminate\Database\Eloquent\Collection;

class PlayerTitleService
{
    public function setActiveTitle(Player $player, int $titleId)
    {
        $player->active_title_id = $titleId;
        $player->save();
    }
    public function grantTitle(Player $player, string $titleName)
    {
        // Check if the title exists in the database
        $title = Title::where('title', $titleName)->first();

        if (!$title) {
            // Title does not exist, throw an exception
            throw new \InvalidArgumentException("Title '$titleName' does not exist.");
        }

        // Grant the title
        $player->titles()->syncWithoutDetaching([$title->id]);
    }
    public function getActiveTitle(Player $player)
    {
        return $player->activeTitle;
    }
}

<?php

namespace App\Http\Services;

use App\Http\Resources\PlayerResource;
use App\Models\Player;

class PlayerService
{
  public function getProfile(Player $player)
  {
    return PlayerResource::make($player->load(['titles', 'activeTitle']));
  }
}

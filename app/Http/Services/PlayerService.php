<?php

namespace App\Http\Services;

use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Models\Title;
use Illuminate\Support\Facades\Auth;

class PlayerService
{
  public function getProfile(Player $player)
  {
    if (!$player) {
      throw new \InvalidArgumentException("Player must be provided.");
    }

    $profile = PlayerResource::make($player->load(['titles', 'activeTitle']));

    return $profile;
  }

  public function getActiveTitle(Player $player)
  {
    if (!$player->activeTitle) {
      return ['active_title' => 1];
    }

    return [
      'active_title' => $player->activeTitle->name
    ];
    // return [$player->activeTitle->name ? $player->activeTitle->name : null];
  }

  public function grantTitle(Player $player, string $titleName)
  {
    try {
      $title = Title::firstOrCreate(['name' => $titleName]);

      $player->titles()->attach($title->id);

      return response("Title granted", 200);
    } catch (\Exception $e) {
      info($e->getMessage());
      return null;
    }
  }

  public function setActiveTitle(Player $player, string $titleName)
  {
    try {
      $title = $player->titles()->whereName($titleName)->firstOrFail();

      $player->active_title_id = $title->id;

      $player->save();

      return response("Title granted", 200);
    } catch (\Exception $e) {

      return $e->getMessage();
    }
  }
}

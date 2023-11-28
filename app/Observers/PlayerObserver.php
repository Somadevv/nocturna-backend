<?php

namespace App\Observers;

use App\Models\Player;
use App\Models\Title;

class PlayerObserver
{
    public function __construct(private Title $title)
    {
        $this->title = Title::where("title", 'Noob')->first();
    }
    /**
     * Handle the Player "created" event.
     */


    public function created(Player $player): void
    {
        $player->titles()->sync($this->title);
    }

    public function creating(Player $player): void
    {
        $player->active_title_id = $this->title->id;
    }

    /**
     * Handle the Player "updated" event.
     */
    public function updated(Player $player): void
    {
        //
    }

    /**
     * Handle the Player "deleted" event.
     */
    public function deleted(Player $player): void
    {
        //
    }

    /**
     * Handle the Player "restored" event.
     */
    public function restored(Player $player): void
    {
        //
    }

    /**
     * Handle the Player "force deleted" event.
     */
    public function forceDeleted(Player $player): void
    {
        //
    }
}

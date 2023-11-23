<?php

namespace App\Http\Resources;

use App\Http\Resources\Titles\TitlesResource;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PlayerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $unlockedTitles = $this->unlockedTitles->sortBy('id')->values();

        return [
            "username" => $this->username,
            "activeTitle" => $this->activeTitle()->first()->title,
            "unlockedTitles" => TitlesResource::collection($unlockedTitles),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Http\Resources\Titles\TitlesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $unlockedTitles = $this->unlockedTitles->sortBy('id')->values();

        return [
            "meta" => [
                "username" => $this->username
            ],
            "titles" => [
                "active" => $this->activeTitle()->first()->title,
                "unlocked" => TitlesResource::collection($unlockedTitles)
            ],
            "stats" => [
                "experience" => 100,
                "experienceToLevel" => 500,
                "levels" => [
                    "playerLevel" => $this->level,
                    "alchemyLevel" => 1,
                    "craftingLevel" => 1,
                    "smithingLevel" => 1
                ]

            ]
        ];
    }
}

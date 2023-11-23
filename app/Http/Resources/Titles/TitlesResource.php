<?php

namespace App\Http\Resources\Titles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TitlesResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
        ];
    }
}

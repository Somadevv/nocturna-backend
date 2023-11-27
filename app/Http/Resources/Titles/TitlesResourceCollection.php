<?php

namespace App\Http\Resources\Titles;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TitlesResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return $this->collection->sortBy('id')->map->toArray($request)->all();
    }
}

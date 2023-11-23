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
        // Use the sortBy method to sort the collection by the 'id'
        // $sortedTitles = $this->collection->sortByDesc('id');

        // return $sortedTitles->map(function ($item) {
        //     return (new TitlesResource($item))->toArray($this->resource);
        // })->all();

        return $this->collection->sortBy('id')->map->toArray($request)->all();
    }
}

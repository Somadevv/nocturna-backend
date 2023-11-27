<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemResourceCollection extends ResourceCollection
{

    public function toArray(Request $request): array
    {
        return $this->collection->sortBy('id')->map->toArray($request)->all();
    }
}

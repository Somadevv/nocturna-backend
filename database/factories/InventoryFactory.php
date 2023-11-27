<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class InventoryFactory extends Factory
{

    public function definition(): array
    {
        return [
            'player_id' => 1,
            'item_id' => $this->faker->numberBetween(1, 10),
            'quantity' => $this->faker->numberBetween(1, 10)
        ];
    }
}

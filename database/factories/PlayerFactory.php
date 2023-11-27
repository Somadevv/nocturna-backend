<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    public $timestamps = false;
    public function definition(): array
    {
        return [
            "username" => 'jubbly',
            "active_title_id" => 1,
            "password" => '123',
        ];
    }
}

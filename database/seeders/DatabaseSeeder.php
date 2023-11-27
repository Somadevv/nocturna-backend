<?php

namespace Database\Seeders;


use App\Models\Player;
use App\Models\Title;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Player::factory(1)->create();


        $this->call([
            TitleSeeder::class,
            PlayerTitleSeeder::class,
            ItemSeeder::class,
            InventorySeeder::class
        ]);
    }
}

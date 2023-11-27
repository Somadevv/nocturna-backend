<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Array of 100 items with random names

        // Function to generate a random name
        function generateRandomName()
        {
            $adjectives = ['Swift', 'Mystic', 'Daring', 'Silent', 'Vivid', 'Wise', 'Eternal', 'Radiant', 'Harmonic', 'Brilliant'];
            $nouns = ['Dragon', 'Phoenix', 'Sword', 'Shield', 'Orb', 'Serpent', 'Amulet', 'Falcon', 'Crown', 'Whisper'];

            $randomAdjective = $adjectives[array_rand($adjectives)];
            $randomNoun = $nouns[array_rand($nouns)];

            return "{$randomAdjective} {$randomNoun}";
        }

        $items = [];

        for ($i = 1; $i <= 100; $i++) {
            $name = generateRandomName();
            $items[] = ['name' => $name, 'price' => random_int(1, 500)];
        }

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}

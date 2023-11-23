<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{

    public function run(): void
    {
        $titles = ['Noob', 'Expert', 'Novice', 'Newbie'];

        foreach ($titles as $title) {
            Title::factory()->create(['title' => $title]);
        }

    }
}

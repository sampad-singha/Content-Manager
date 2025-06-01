<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::factory()->count(50)->create();
        Content::factory()->count(20)->create([
            'university' => 'University of Dhaka',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Email::factory()->count(20)->create();
        Email::factory()->count(12)->create([
            'receiver' => 'pranrfl@mis.bd',
        ]);
    }
}

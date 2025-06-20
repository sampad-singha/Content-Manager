<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->create();
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@pranrfl.bd',
            'password' => Hash::make('password'),
        ]);
    }
}

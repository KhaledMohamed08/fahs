<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Foundation',
                'phone' => '01010101010',
                'email' => 'foundation@email.com',
                'type' => 'foundation',
            ],
            [
                'name' => 'Participant',
                'phone' => '01011121314',
                'email' => 'participant@email.com',
                'type' => 'participant',
            ],
        ]);

        User::factory(10)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->create([
            'name' => 'super admin',
            'email' => 'super-admin@fahs.com',
            'phone' => '01010101010',
            'type' => 'super_admin',
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
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

        User::factory()->create([
            'name' => 'Test User',
            'national_id' => '12345678901234',
            'phone' => '01000000000',
        ]);

        Report::factory(5)->create([
            'user_id' => 1,
            'll' => '20.2324',
            'lg' => '20.2324',
            'report' => 'test',
        ]);
    }
}

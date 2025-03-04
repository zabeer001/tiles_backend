<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 random users using factory
        \App\Models\User::factory(10)->create();

        // Create a specific user with custom attributes
        \App\Models\User::factory()->create([
            'name' => 'zabeer',
            'email' => 'z@gmail.com',
            'password' => Hash::make('password'), // Make sure to hash the password
        ]);

       

        // Seed the departments table
        $this->call([
            // DepartmentsTableSeeder::class,
            // Add other seeders here as needed (e.g., EmployeesTableSeeder)
        ]);
    }
}

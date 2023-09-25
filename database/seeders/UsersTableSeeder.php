<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();

        // Test user data
        $testUserData = file_get_contents(database_path('seeders/data/users.json'));
        $testUser = json_decode($testUserData, true);

        // Insert test user into Users table
        DB::table('users')->insert([
            [
                'first_name' => $testUser['first_name'],
                'last_name' => $testUser['last_name'],
                'full_name' => $testUser['full_name'],
                'email' => $testUser['email'],
                'password' => app('hash')->make($testUser['password'])
            ]
        ]);
    }
}
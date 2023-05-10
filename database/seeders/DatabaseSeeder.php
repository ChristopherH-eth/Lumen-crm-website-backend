<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable mass assignment restrictions
        Model::unguard();

        // Seed database
        $this->call(UsersTableSeeder::class);
        $this->call(AccountsTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(LeadsTableSeeder::class);
        $this->call(OpportunitiesTableSeeder::class);

        // Enable mass assignment restrictions
        Model::reguard();
    }
}

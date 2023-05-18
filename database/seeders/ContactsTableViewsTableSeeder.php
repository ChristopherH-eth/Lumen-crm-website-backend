<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactsTableViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableView = [
            ['id' => 0, 'col' => 'full_name', 'text' => 'Name', 'width' => 150],
            ['id' => 1, 'col' => 'account.account_name', 'text' => 'Account Name', 'width' => 150],
            ['id' => 2, 'col' => 'title', 'text' => 'Title', 'width' => 150],
            ['id' => 3, 'col' => 'phone', 'text' => 'Phone', 'width' => 150],
            ['id' => 4, 'col' => 'user.full_name', 'text' => 'Contact Owner', 'width' => 150]
        ];

        DB::table('contacts_table_views')->insert([
            'name' => 'default',
            'view_data' => json_encode($tableView)
        ]);
    }
}
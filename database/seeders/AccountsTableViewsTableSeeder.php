<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableView = [
            ['id' => 0, 'col' => 'account_name', 'text' => 'Account Name', 'width' => 200],
            ['id' => 1, 'col' => 'state_province', 'text' => 'State/Province', 'width' => 200],
            ['id' => 2, 'col' => 'phone', 'text' => 'Phone', 'width' => 200],
            ['id' => 3, 'col' => 'user.full_name', 'text' => 'Account Owner', 'width' => 200]
        ];

        DB::table('accounts_table_views')->insert([
            'name' => 'default',
            'view_data' => json_encode($tableView)
        ]);
    }
}
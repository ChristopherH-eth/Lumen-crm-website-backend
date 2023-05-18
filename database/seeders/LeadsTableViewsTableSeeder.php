<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadsTableViewsTableSeeder extends Seeder
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
            ['id' => 1, 'col' => 'company', 'text' => 'Company', 'width' => 150],
            ['id' => 2, 'col' => 'state_province', 'text' => 'State/Province', 'width' => 150],
            ['id' => 3, 'col' => 'phone', 'text' => 'Phone', 'width' => 150],
            ['id' => 4, 'col' => 'email', 'text' => 'Email', 'width' => 150],
            ['id' => 5, 'col' => 'lead_status', 'text' => 'Lead Status', 'width' => 150],
            ['id' => 6, 'col' => 'user.full_name', 'text' => 'Lead Owner', 'width' => 150]
        ];

        DB::table('leads_table_views')->insert([
            'name' => 'default',
            'view_data' => json_encode($tableView)
        ]);
    }
}
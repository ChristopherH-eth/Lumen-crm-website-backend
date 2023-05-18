<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpportunitiesTableViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableView = [
            ['id' => 0, 'col' => 'opportunity_name', 'text' => 'Opportunity', 'width' => 200]
        ];

        DB::table('opportunities_table_views')->insert([
            'name' => 'default',
            'view_data' => json_encode($tableView)
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default layouts
        $defaultLayoutData = file_get_contents(database_path('seeders/data/layouts.json'));
        $layouts = json_decode($defaultLayoutData, true);

        // Iterate over layouts from file to get each name and corresponding data
        foreach ($layouts as $layout)
        {
            $layoutName = $layout['name'];
            $layoutData = $layout;

            // Process each layout
            $this->processLayout($layoutName, $layoutData);
        }
    }

    /**
     * Process each layout and insert into database
     * 
     * @param $layoutName
     * @param $layoutData
     * @return void
     */
    private function processLayout($layoutName, $layoutData)
    {
        DB::table('layouts')->insert([
            [
                'name' => $layoutName,
                'layout_data' => json_encode($layoutData)
            ]
        ]);
    }
}
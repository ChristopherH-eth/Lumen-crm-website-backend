<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactsActionBarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actionBar = [
            ['id' => 0, 'button' => 'new', 'text' => 'New', 'options' => ['hasMenu' => false]],
            ['id' => 1, 'button' => 'view', 'text' => 'View', 'options' => ['hasMenu' => true]],
            ['id' => 2, 'button' => 'import', 'text' => 'Import', 'options' => ['hasMenu' => false]],
            ['id' => 3, 'button' => 'export', 'text' => 'Export', 'options' => ['hasMenu' => false]],
            ['id' => 4, 'button' => 'more', 'text' => 'More', 'options' => ['hasMenu' => true]]
        ];

        DB::table('contacts_action_bars')->insert([
            'name' => 'default',
            'action_bar_data' => json_encode($actionBar)
        ]);
    }
}
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
        // Default action bar for Contact collections
        $defaultCollectionActionBar = [
            ['id' => 0, 'button' => 'new', 'text' => 'New', 'options' => ['hasMenu' => false]],
            ['id' => 1, 'button' => 'view', 'text' => 'View', 'options' => ['hasMenu' => true],
                'menu' => [
                    ['id' => 0, 'text' => 'New'], 
                    ['id' => 1, 'text' => 'Edit'], 
                    ['id' => 2, 'text' => 'Manage']
                ]
            ],
            ['id' => 2, 'button' => 'import', 'text' => 'Import', 'options' => ['hasMenu' => false]],
            ['id' => 3, 'button' => 'export', 'text' => 'Export', 'options' => ['hasMenu' => false]],
            ['id' => 4, 'button' => 'more', 'text' => 'More', 'options' => ['hasMenu' => true],
                'menu' => [
                    ['id' => 0, 'text' => 'More Items']
                ]
            ]
        ];

        // Default action bar for Contact entries
        $defaultEntryActionBar = [
            ['id' => 0, 'button' => 'edit', 'text' => 'Edit', 'options' => ['hasMenu' => false]],
            ['id' => 1, 'button' => 'delete', 'text' => 'Delete', 'options' => ['hasMenu' => false]]
        ];

        DB::table('contacts_action_bars')->insert([
            [
                'name' => 'collection_default',
                'action_bar_data' => json_encode($defaultCollectionActionBar)
            ],
            [
                'name' => 'entry_default',
                'action_bar_data' => json_encode($defaultEntryActionBar)
            ]
        ]);
    }
}
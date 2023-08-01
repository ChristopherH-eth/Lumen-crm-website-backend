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
        // Default layout for Leads
        $defaultLeadsLayout = [
            [
                'label' => 'Subheader - Lead Information'
            ],
            [
                'label' => 'Lead Owner'
            ],
            [
                'id' => 'lead-form--salutation', 
                'logical_name' => 'salutation', 
                'label' => 'Salutation', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--first-name', 
                'logical_name' => 'first_name', 
                'label' => 'First Name', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => true
                ]
            ],
            [
                'id' => 'lead-form--last-name', 
                'logical_name' => 'last_name', 
                'label' => 'Last Name', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => true
                ]
            ],
            [
                'id' => 'lead-form--company', 
                'logical_name' => 'company', 
                'label' => 'Company', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => true
                ]
            ],
            [
                'id' => 'lead-form--title', 
                'logical_name' => 'title', 
                'label' => 'Title', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--website', 
                'logical_name' => 'website', 
                'label' => 'Website', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--description', 
                'logical_name' => 'description', 
                'label' => 'Description', 
                'type' => 'text',
                'field_type' => 'textarea',
                'rows' => 5,
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--status', 
                'logical_name' => 'status', 
                'label' => 'Lead Status', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => true
                ]
            ],
            [
                'label' => 'Subheader - Get In Touch'
            ],
            [
                'id' => 'lead-form--phone', 
                'logical_name' => 'phone', 
                'label' => 'Phone', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--email', 
                'logical_name' => 'email', 
                'label' => 'Email', 
                'type' => 'email',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--email-opt-out', 
                'logical_name' => 'email_opt_out', 
                'label' => 'Email Opt Out', 
                'type' => 'checkbox',
                'field_type' => 'checkbox',
                'options' => [
                    'isRequired' => true
                ]
            ],
            [
                'label' => 'Subheader - Address'
            ],
            [
                'id' => 'lead-form--street', 
                'logical_name' => 'street', 
                'label' => 'Street', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--city', 
                'logical_name' => 'city', 
                'label' => 'City', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--state-province', 
                'logical_name' => 'state_province', 
                'label' => 'State / Province', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--zip-postal', 
                'logical_name' => 'zip_postal', 
                'label' => 'Zip / Postal Code', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--country', 
                'logical_name' => 'country', 
                'label' => 'Country', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'label' => 'Subheader - Segment'
            ],
            [
                'id' => 'lead-form--no-of-employees', 
                'logical_name' => 'no_of_employees', 
                'label' => 'No. of Employees', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--state-province', 
                'logical_name' => 'state_province', 
                'label' => 'State / Province', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--annual-revenue', 
                'logical_name' => 'annual_revenue', 
                'label' => 'Annual Revenue', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--source', 
                'logical_name' => 'source', 
                'label' => 'Lead Source', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ],
            [
                'id' => 'lead-form--industry', 
                'logical_name' => 'industry', 
                'label' => 'Industry', 
                'type' => 'text',
                'field_type' => 'text',
                'options' => [
                    'isRequired' => false
                ]
            ]
        ];

        DB::table('layouts')->insert([
            [
                'name' => 'leads_default',
                'layout_data' => json_encode($defaultLeadsLayout)
            ]
        ]);
    }
}
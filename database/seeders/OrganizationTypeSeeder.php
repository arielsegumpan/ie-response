<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'org_type_name' => 'Fire and Rescue Agency',
                'org_type_description' => 'Agencies responsible for fire safety and rescue operations.',
                'org_type_img' => null,
            ],
            [
                'org_type_name' => 'Law Enforcement Agency',
                'org_type_description' => 'Agencies responsible for law enforcement and public safety.',
                'org_type_img' => null,
            ],
            [
                'org_type_name' => 'Volunteer Organization',
                'org_type_description' => 'Community-driven organizations offering voluntary support.',
                'org_type_img' => null,
            ],
            [
                'org_type_name' => 'Special Response Unit',
                'org_type_description' => 'Units trained for special or tactical operations including K9 units.',
                'org_type_img' => null,
            ],
        ];

        foreach ($types as $type) {
            OrganizationType::create($type);
        }
    }
}

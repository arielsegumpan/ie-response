<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use App\Models\OrganizationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fireRescueType = OrganizationType::where('org_type_name', 'Fire and Rescue Agency')->first();
        $lawEnforcementType = OrganizationType::where('org_type_name', 'Law Enforcement Agency')->first();
        $volunteerType = OrganizationType::where('org_type_name', 'Volunteer Organization')->first();
        $specialResponseType = OrganizationType::where('org_type_name', 'Special Response Unit')->first();

        Organization::create([
            'org_name' => 'Bureau of Fire Protection (BFP)',
            'organization_type_id' => $fireRescueType->id,
            'org_email' => 'bfp@gov.ph',
            'org_contact_person' => 'Chief Fire Officer Juan Dela Cruz',
            'org_contact_phone' => '02-1234-5678',
            'org_contact_email' => 'chief@bfp.gov.ph',
            'org_img' => null,
            'org_description' => 'National fire protection and emergency response agency.',
        ]);

        Organization::create([
            'org_name' => 'Philippine National Police (PNP)',
            'organization_type_id' => $lawEnforcementType->id,
            'org_email' => 'pnp@gov.ph',
            'org_contact_person' => 'Gen. Maria Santos',
            'org_contact_phone' => '02-8765-4321',
            'org_contact_email' => 'contact@pnp.gov.ph',
            'org_img' => null,
            'org_description' => 'The national police force of the Philippines.',
        ]);

        Organization::create([
            'org_name' => 'Guardians',
            'organization_type_id' => $volunteerType->id,
            'org_email' => 'guardians@gmail.com',
            'org_contact_person' => 'Cmdr. Jose Rizal',
            'org_contact_phone' => '0917-111-2222',
            'org_contact_email' => 'cmdr@guardians.org',
            'org_img' => null,
            'org_description' => 'A volunteer community organization for peace and order.',
        ]);

        Organization::create([
            'org_name' => 'K9 Responder Unit',
            'organization_type_id' => $specialResponseType->id,
            'org_email' => 'k9unit@responder.org',
            'org_contact_person' => 'Officer K9 Handler',
            'org_contact_phone' => '0998-888-7777',
            'org_contact_email' => 'contact@k9responder.org',
            'org_img' => null,
            'org_description' => 'Special response unit with trained K9s for search and rescue.',
        ]);
    }
}

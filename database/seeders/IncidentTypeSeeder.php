<?php

namespace Database\Seeders;

use App\Models\IncidentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IncidentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incidents = [
            // 🚧 Road and Traffic Incidents
            'Car Accident',
            'Motorcycle Accident',
            'Tricycle (Trisikad) Accident',
            'Pedestrian Hit-and-Run',
            'Traffic Congestion',
            'Road Blockage (due to fallen tree/debris)',
            'Overturned Vehicle',
            'Vehicular Collision with Property',
            'Public Utility Vehicle (PUV) Breakdown',
            'Road Rage Incident',

            // 🌧️ Weather-Related Incidents
            'Flash Flood',
            'Heavy Rainfall',
            'Landslide',
            'Strong Winds (causing damage)',
            'Lightning Strike Incident',
            'Heatstroke Report',
            'Tornado or Whirlwind',

            // 🔥 Fire and Hazardous Incidents
            'Residential Fire',
            'Commercial Fire',
            'Forest/Grass Fire',
            'Gas Leak',
            'Electrical Fire',
            'Chemical Spill',
            'Smoke Emission (Unknown Source)',

            // 🏥 Medical and Health-Related
            'Sudden Illness in Public Area',
            'Unresponsive Person Found',
            'COVID-19 Suspected Case',
            'Heatstroke/Fainting Incident',
            'Animal Bite',
            'Drowning Incident',

            // 🧍 Public Disturbance and Safety
            'Street Fight',
            'Theft or Robbery in Progress',
            'Missing Person',
            'Intoxicated Individual',
            'Vandalism',
            'Suspicious Package or Object',
            'Noise Complaint',

            // 🚨 Emergency and Rescue
            'Search and Rescue Operation',
            'Building Collapse',
            'Elevator Entrapment',
            'Stranded Individuals due to Flood',
            'Fire Alarm Triggered (False/Real)',

            // 🐾 Animal-Related Incidents
            'Stray Animal Attack',
            'Animal in Distress',
            'Livestock on the Road',
            'Snake Sighting or Capture',
        ];

        foreach ($incidents as $incident) {
            IncidentType::create([
                'inc_name' => $incident,
                'inc_slug' => Str::slug($incident),
                'inc_description' => 'Reported incident: ' . $incident,
            ]);
        }
    }
}

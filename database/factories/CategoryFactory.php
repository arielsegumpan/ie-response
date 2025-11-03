<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Accident Reports',
            'Fire Incidents',
            'Flood Alerts',
            'Search and Rescue',
            'Evacuation Zones',
            'Medical Emergencies',
            'Hazardous Material',
            'Security Breach',
            'Natural Disasters',
            'Power Outages',
        ]);

        return [
            'cat_name' => $name,
            'cat_slug' => Str::slug($name),
            'cat_desc' => $this->faker->sentence(),
        ];
    }
}

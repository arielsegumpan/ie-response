<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'accident',
            'fire',
            'flood',
            'rescue',
            'evacuation',
            'medical',
            'hazmat',
            'security',
            'earthquake',
            'blackout',
        ]);

        return [
            'tag_name' => ucfirst($name),
            'tag_slug' => Str::slug($name),
            'tag_desc' => $this->faker->sentence(),
        ];
    }
}

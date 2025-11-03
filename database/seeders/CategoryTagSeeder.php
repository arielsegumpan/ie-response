<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'cat_name' => 'Local News',
                'cat_slug' => 'local-news',
                'cat_desc' => 'Updates and events happening within local communities.'
            ],
            [
                'cat_name' => 'Traffic Update',
                'cat_slug' => 'traffic-update',
                'cat_desc' => 'Latest updates and changes in road traffic conditions.'
            ],
            [
                'cat_name' => 'Accident Reports',
                'cat_slug' => 'accident-reports',
                'cat_desc' => 'Details and investigations on road and public accidents.'
            ],
            [
                'cat_name' => 'Safety Tips',
                'cat_slug' => 'safety-tips',
                'cat_desc' => 'Guides and best practices for road and personal safety.'
            ],
            [
                'cat_name' => 'Emergency News',
                'cat_slug' => 'emergency-news',
                'cat_desc' => 'Urgent updates related to emergencies and rescue operations.'
            ],
        ];

        $tags = [
            ['tag_name' => 'Traffic', 'tag_slug' => 'traffic', 'tag_desc' => 'Topics related to traffic and road conditions.'],
            ['tag_name' => 'Accident', 'tag_slug' => 'accident', 'tag_desc' => 'Articles involving vehicular or other types of accidents.'],
            ['tag_name' => 'Ceres Bus', 'tag_slug' => 'ceres-bus', 'tag_desc' => 'News specific to the Ceres Bus.'],
            ['tag_name' => 'Negros Occidental', 'tag_slug' => 'negros-occidental', 'tag_desc' => 'News specific to the province of Negros Occidental.'],
            ['tag_name' => 'Road Safety', 'tag_slug' => 'road-safety', 'tag_desc' => 'Tips and discussions on ensuring road safety.'],
            ['tag_name' => 'Collision', 'tag_slug' => 'collision', 'tag_desc' => 'Incidents involving vehicle collisions.'],
            ['tag_name' => 'Victorias City', 'tag_slug' => 'victorias-city', 'tag_desc' => 'Happenings and events in Victorias City.'],
            ['tag_name' => 'Public Transport', 'tag_slug' => 'public-transport', 'tag_desc' => 'News and updates on public transportation.'],
            ['tag_name' => 'Investigation', 'tag_slug' => 'investigation', 'tag_desc' => 'Ongoing investigations on reported incidents.'],
            ['tag_name' => 'Fatality', 'tag_slug' => 'fatality', 'tag_desc' => 'Reports involving loss of life.'],
            ['tag_name' => 'Emergency Response', 'tag_slug' => 'emergency-response', 'tag_desc' => 'Coverage of emergency rescue and response efforts.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['cat_slug' => $category['cat_slug']], $category);
        }

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['tag_slug' => $tag['tag_slug']], $tag);
        }
    }
}

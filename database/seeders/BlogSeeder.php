<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch tags and categories using slug as key
        $tagsBySlug = Tag::all()->keyBy('tag_slug');
        $categoriesBySlug = Category::all()->keyBy('cat_slug');

        $blogs = [
            [
                "data" => [
                    "user_id" => 1,
                    "title" => "Tricycle Driver Killed, Passenger Injured in Victorias Collision",
                    "slug" => "tricycle-driver-killed-passenger-injured-victorias-collision",
                    "content" => "On August 20, 2023, a tragic accident occurred in Barangay 13, Victorias City, when a tricycle was rear-ended by a Ceres bus along the national highway. The tricycle, driven by 25-year-old Elf Sanipa from Barangay 10, malfunctioned and swerved into the opposite lane, leading to the collision.​

                    The impact resulted in the immediate death of Sanipa, while his passenger, 29-year-old Jenalyn Navarro from Barangay Vista Alegre, Bacolod City, sustained injuries. Navarro was promptly transported to Corazon Locsin Montelibano Memorial Regional Hospital in Bacolod City for medical treatment.​

                    Authorities have impounded both vehicles involved for proper investigation. The bus driver, 49-year-old Lemuel Fajardo from Barangay Bug-ang, Toboso town, was temporarily detained at the Victorias Police Station pending further inquiries.

                    The Victorias City Police Department urges all motorists to exercise caution and ensure their vehicles are in good working condition to prevent such accidents. They also remind drivers to adhere to traffic regulations to ensure the safety of all road users.",
                    "featured_img" => "https://via.placeholder.com/640x480.png?text=Accident",
                    "status" => "published",
                    "is_featured" => false,
                    "is_visible" => true,
                    "metadata" => [
                        "seo_title" => "Tricycle Driver Killed, Passenger Injured in Victorias Collision",
                        "seo_description" => "A fatal collision in Victorias City resulted in the death of a tricycle driver and injuries to his passenger after being rear-ended by a Ceres bus.",
                        "seo_keywords" => "Victorias City, Negros Occidental, tricycle accident, Ceres bus, road collision"
                    ]
                ],
                "tags" => ['accident', 'traffic', 'ceres-bus', 'victorias-city', 'negros-occidental'],
                "categories" => ['accident-reports', 'local-news']
            ],
            [
                "data" => [
                    "user_id" => 1,
                    "title" => "One Dead, Five Injured in Victorias Vehicle Collision",
                    "slug" => "one-dead-five-injured-victorias-vehicle-collision",
                    "content" => "A severe vehicular accident transpired on Osmeña Avenue in Victorias City, leading to the death of a 19-year-old resident from Cadiz City and injuries to five others. The incident involved a head-on collision between a refrigerated van and a dump truck early Wednesday morning. Eyewitnesses reported that the dump truck lost control and veered into the opposite lane, colliding with the van carrying the victims. Authorities responded quickly to the scene and transported the injured to a nearby hospital. The driver of the dump truck is currently under police custody pending further investigation. Local officials are calling for stricter traffic enforcement and safety awareness following the tragedy.",
                    "featured_img" => "https://via.placeholder.com/640x480.png?text=Accident",
                    "status" => "published",
                    "is_featured" => false,
                    "is_visible" => true,
                    "metadata" => [
                        "seo_title" => "One Dead, Five Injured in Victorias Vehicle Collision",
                        "seo_description" => "A head-on collision between a refrigerated van and a dump truck in Victorias City resulted in one fatality and multiple injuries.",
                        "seo_keywords" => "Victorias City, Negros Occidental, vehicle collision, road accident, Osmeña Avenue"
                    ]
                ],
                "tags" => ['collision', 'road-safety', 'emergency-response', 'victorias-city', 'negros-occidental'],
                "categories" => ['accident-reports', 'traffic-update']
            ],
            [
                "data" => [
                    "user_id" => 1,
                    "title" => "Elderly Man and Nephew Killed in Victorias Road Accident",
                    "slug" => "elderly-man-nephew-killed-victorias-road-accident",
                    "content" => "On September 19, 2024, a heartbreaking accident claimed the lives of an elderly man and his young nephew in Victorias City. According to the initial police report, the victims were riding a motorcycle when they suddenly lost control and crashed into a concrete barrier near the city’s northern bypass road. Both victims were pronounced dead on arrival at the hospital. Family members expressed deep grief, describing the victims as close companions who often traveled together. Investigators are still determining if speed or mechanical failure contributed to the crash. Meanwhile, local authorities urge motorists to exercise extreme caution, especially during nighttime travel.",
                    "featured_img" => "https://via.placeholder.com/640x480.png?text=Accident",
                    "status" => "published",
                    "is_featured" => false,
                    "is_visible" => true,
                    "metadata" => [
                        "seo_title" => "Elderly Man and Nephew Killed in Victorias Road Accident",
                        "seo_description" => "A tragic accident in Victorias City resulted in the deaths of an elderly man and his nephew after their vehicle crashed into a barrier.",
                        "seo_keywords" => "Victorias City, Negros Occidental, road accident, vehicle crash, fatalities"
                    ]
                ],
                "tags" => ['fatality', 'road-safety', 'victorias-city', 'accident', 'negros-occidental'],
                "categories" => ['accident-reports', 'safety-tips']
            ]
        ];

        foreach ($blogs as $entry) {
            $blog = Blog::create($entry['data']);

            // Attach tags safely using slugs
            $tagIds = collect($entry['tags'])->map(function ($slug) use ($tagsBySlug) {
                if (!isset($tagsBySlug[$slug])) {
                    throw new \Exception("Tag with slug '{$slug}' not found.");
                }
                return $tagsBySlug[$slug]->id;
            })->toArray();

            // Attach categories safely using slugs
            $categoryIds = collect($entry['categories'])->map(function ($slug) use ($categoriesBySlug) {
                if (!isset($categoriesBySlug[$slug])) {
                    throw new \Exception("Category with slug '{$slug}' not found.");
                }
                return $categoriesBySlug[$slug]->id;
            })->toArray();

            $blog->tags()->attach($tagIds);
            $blog->categories()->attach($categoryIds);
        }
    }
}

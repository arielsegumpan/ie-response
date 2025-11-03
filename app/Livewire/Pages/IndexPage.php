<?php

namespace App\Livewire\Pages;

use Carbon\Carbon;
use App\Models\Blog;
use Livewire\Component;
use App\Models\Incident;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Storage;

class IndexPage extends Component
{

    // public $incidents;

    #[Computed()]
    public function featuredPosts()
    {
        return Blog::query()->with([
            'categories:id,cat_name,cat_slug',
            'tags:id,tag_name,tag_slug'
            ])
            ->where('is_visible', 1)
            ->where('is_featured', 1)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

    }

    #[Computed()]
    public function incidents()
    {
        return Incident::query()->with([
            'type',
            'location',
            'images' => function ($query) {
                $query->take(3);
            }
        ])
        ->orderBy('created_at', 'desc')
        ->get()
        ->transform(function ($incident) {
            $incident->formatted_created_at = $incident->created_at->diffForHumans();
            $incident->images->transform(function ($image) {
                $image->image_url = Storage::url($image->image_path);
                return $image;
            });

            return $incident;
        })
        ->map(function ($incident) {
            $incident->carb_created_at = $incident->created_at->format("F j, Y, g:i a");
            return $incident;
        });
    }

    #[Layout('layouts.app')]
    #[Title('Home')]
    public function render()
    {
        return view('livewire.pages.index-page');
    }
}

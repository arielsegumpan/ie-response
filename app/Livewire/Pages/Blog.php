<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\Blog as Blogs;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

class Blog extends Component
{
    use WithPagination;

    #[Computed()]
    public function blogs()
    {
        return Blogs::query()->with([
            'categories:id,cat_name,cat_slug',
            'tags:id,tag_name,tag_slug'
            ])
            ->where('is_visible', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(6)
            ->through(function ($post) {
                $post->strip_content = Str::limit(strip_tags($post->content), 70);
                return $post;
            });
    }

    #[Computed()]
    public function featuredPost()
    {
        return Blogs::query()->with([
            'categories:id,cat_name,cat_slug',
            'tags:id,tag_name,tag_slug'
        ])
        ->where('is_visible', 1)
        ->orderBy('created_at', 'desc')
        ->first();
    }


    #[Layout('layouts.app')]
    #[Title('Blog')]
    public function render()
    {
        return view('livewire.pages.blog');
    }
}

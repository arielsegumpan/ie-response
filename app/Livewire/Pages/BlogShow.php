<?php

namespace App\Livewire\Pages;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
<<<<<<< HEAD
use Livewire\Attributes\Locked;
=======
use Illuminate\Database\Eloquent\Collection;
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2

class BlogShow extends Component
{
    #[Locked]
    public string $slug;

    #[Computed()]
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    #[Computed()]
    public function blog()
    {
        return Blog::query()
            ->select([
                'id',
                'slug',
                'title',
                'content',
                'user_id',
                'created_at',
                'updated_at',
                // Add only the columns you actually need
            ])
            ->with([
                'categories:id,cat_name,cat_slug',
                'tags:id,tag_name,tag_slug'
            ])
            ->where('slug', $this->slug)
            ->firstOrFail();
    }

    #[Computed()]
    public function relatedBlogs()
    {
        return Blog::query()
            ->select([
                'id',
                'user_id',
                'title',
                'slug',
                'content',
                'featured_img',
                'created_at',
            ])
            ->where('user_id', $this->blog->user_id)
            ->where('id', '!=', $this->blog->id)
            ->latest()
            ->take(5)
            ->get();
    }

    // If metadata is used, make it computed too
    #[Computed(persist: true)]
    public function metadata()
    {
        return $this->blog->metadata ?? [];
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.blog-show');
    }
}

<?php

namespace App\Livewire\Pages\BlogExtras;

use App\Models\Blog;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

class CategoryPosts extends Component
{
    use WithPagination;

    public ?Category $category = null;
    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->category = Category::query()->where('cat_slug', $slug)->firstOrFail();
    }

    #[Computed()]
    public function postsCategories()
    {
        return Blog::query()->whereHas('categories', function ($query) {
            $query->where('cat_slug', $this->slug);
        })
        ->where('is_visible', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->through(function ($post) {
            $post->content = Str::limit(strip_tags($post->content), 70);
            return $post;
        });
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.blog-extras.category-posts');
    }
}

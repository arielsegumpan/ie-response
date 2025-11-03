<?php

namespace App\Livewire\Pages\BlogExtras;

use App\Models\Tag;
use App\Models\Blog;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Collection;

class TagPosts extends Component
{
    use WithPagination;

    public ?Tag $tag = null;
    protected string $slug;

    #[Computed()]
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->tag = Tag::query()->where('tag_slug', $slug)->firstOrFail();
    }


    #[Computed()]
    public function postsTags()
    {
        return Blog::query()->whereHas('tags', function ($query) {
            $query->where('tag_slug', $this->slug);
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
        return view('livewire.pages.blog-extras.tag-posts');
    }
}

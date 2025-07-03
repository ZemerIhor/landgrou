<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;

class BlogPage extends Component
{
    use WithPagination;

    public $selectedCategory = 'blog'; // Default to 'blog' for tab navigation

    public function render()
    {
        $posts = BlogPost::query()
            ->where('published', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(12); // 12 posts to fill three rows of 4

        return view('livewire.blog-page', [
            'posts' => $posts,
        ]);
    }

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
        $this->resetPage(); // Reset pagination when category changes
    }
}

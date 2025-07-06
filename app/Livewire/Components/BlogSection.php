<?php

namespace App\Livewire\Components;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;

class BlogSection extends Component
{
    use WithPagination;

    public $perPage = 6; // Количество постов на странице

    public function render()
    {
        $blogPosts = BlogPost::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.components.blog-section', [
            'blogPosts' => $blogPosts,
        ]);
    }
}

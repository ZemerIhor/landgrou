<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;

class BlogPage extends Component
{
    public function render()
    {
        return view('livewire.blog-page', [
            'posts' => BlogPost::where('published', true)->latest()->get(),
        ]);
    }
}

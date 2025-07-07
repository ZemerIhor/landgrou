<?php

namespace App\Livewire\Components;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewsSection extends Component
{
    use WithPagination;

    public $perPage = 6; // Number of reviews per page

    public function render()
    {
        $reviews = Review::query()
            ->where('published', true)
            ->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->take(4); // Limit to 4 reviews for the section

        return view('livewire.components.reviews-section', [
            'reviews' => $reviews,
        ]);
    }
}

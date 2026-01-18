<?php

namespace App\Livewire;

use Livewire\Component;

class PublicOfferPage extends Component
{
    public function render()
    {
        return view('livewire.public-offer-page')
            ->layout('layouts.storefront');
    }
}

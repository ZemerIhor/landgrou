<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $subject = '';
    public $formMessage = '';
    public $rating = 3;
    public $agreePrivacy = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:30',
        'subject' => 'required|string|max:255',
        'formMessage' => 'required|string',
        'agreePrivacy' => 'accepted',
    ];

    public function submit()
    {
        \Log::info('Submit method called', ['name' => $this->name, 'email' => $this->email]);
        $this->validate();

        // Отправка письма
        Mail::to(config('mail.from.address'))->send(
            new ContactFormSubmitted([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'formMessage' => $this->formMessage,
                'rating' => $this->rating,
            ])
        );

        session()->flash('message', 'Форма успішно відправлена!');

        $this->reset([
            'name', 'email', 'phone', 'subject', 'formMessage', 'rating', 'agreePrivacy'
        ]);

        // Закрываем форму
        $this->dispatch('close-contact-form');
    }

    public function updated($propertyName)
    {
        // Валидация только при изменении полей, чтобы минимизировать запросы
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}

<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Log;

class ContactForm extends Component
{
    public $isOpen = false;
    public $state = 'form'; // 'form', 'success', or 'error'

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|email|max:255')]
    public $email = '';

    #[Rule('required|regex:/^\+?\d{10,15}$/')]
    public $phone = '';

    #[Rule('required|string|max:255')]
    public $subject = '';

    #[Rule('required|string|max:1000')]
    public $formMessage = '';

    #[Rule('accepted')]
    public $agreePrivacy = false;

    #[Rule('required|integer|min:1|max:5')]
    public $rating = 0;

    public function mount()
    {
        $this->isOpen = false; // Гарантируем, что модальное окно закрыто при загрузке
        $this->state = 'form';
        $this->resetForm();
    }

    #[On('openContactForm')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->state = 'form';
        $this->resetForm();
    }
    public function resetModal()
    {
        $this->isOpen = false;
        $this->state = 'form';
        $this->reset(['rating', 'name', 'email', 'phone', 'subject', 'formMessage', 'agreePrivacy']);
    }
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
        $this->state = 'form';
        $this->dispatch('closeContactForm');
    }

    public function submit()
    {
        $validated = $this->validate();

        try {
            Mail::to(config('mail.contact_recipient', 'office@landgrou.com'))
                ->send(new ContactFormSubmitted($validated));

            $this->state = 'success';
            $this->resetForm();
            session()->flash('message', __('messages.form_submitted'));
            $this->dispatch('formSubmitted');
        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);
            $this->state = 'error';
            $this->dispatch('formSubmissionFailed');
        }
    }

    public function tryAgain()
    {
        $this->state = 'form';
    }

    public function continueFromSuccess()
    {
        $this->closeModal();
    }

    public function goBack()
    {
        $this->closeModal();
    }

    private function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'subject', 'formMessage', 'agreePrivacy', 'rating']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.components.contact-form');
    }
}

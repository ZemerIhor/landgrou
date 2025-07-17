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
    public $state = 'form';

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
        $this->isOpen = false;
        $this->state = 'form';
        $this->resetForm();
        Log::info('ContactForm mounted', ['isOpen' => $this->isOpen, 'state' => $this->state]);
    }

    #[On('openContactForm')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->state = 'form';
        $this->resetForm();
        Log::info('ContactForm opened', ['isOpen' => $this->isOpen, 'state' => $this->state]);
    }

    public function resetModal()
    {
        $this->reset([
            'name',
            'email',
            'phone',
            'subject',
            'formMessage',
            'agreePrivacy',
            'rating',
            'state',
        ]);
        $this->state = 'form';
        $this->isOpen = false; // Модальное окно закрыто по умолчанию
        Log::info('ContactForm modal reset', ['state' => $this->state, 'isOpen' => $this->isOpen]);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
        $this->state = 'form';
        $this->dispatch('closeContactForm');
        Log::info('ContactForm closed', ['isOpen' => $this->isOpen, 'state' => $this->state]);
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
            Log::info('ContactForm submitted successfully', $validated);
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
        Log::info('ContactForm try again', ['state' => $this->state]);
    }

    public function continueFromSuccess()
    {
        $this->closeModal();
        Log::info('ContactForm continued from success', ['state' => $this->state]);
    }

    public function goBack()
    {
        $this->closeModal();
        Log::info('ContactForm go back', ['state' => $this->state]);
    }

    private function resetForm()
    {
        $this->reset(['name', 'email', 'phone', 'subject', 'formMessage', 'agreePrivacy', 'rating']);
        $this->resetErrorBag();
        Log::info('ContactForm form reset');
    }

    public function render()
    {
        return view('livewire.components.contact-form');
    }
}

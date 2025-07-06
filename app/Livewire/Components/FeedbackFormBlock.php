<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackFormSubmitted;
use Illuminate\Support\Facades\Log;

class FeedbackFormBlock extends Component
{
    public $isOpen = false;
    public $state = 'form'; // 'form', 'success', or 'error'

    #[Rule('required|string|max:255')]
    public $name = '';

    #[Rule('required|string|regex:/^\+?\d{10,15}$/')]
    public $phone = '';

    #[Rule('required|string|max:1000')]
    public $comment = '';

    #[Rule('accepted')]
    public $privacyAgreement = false;

    public $settings;

    public function mount($settings = null)
    {
        $this->settings = $settings;
        $this->isOpen = false;
        $this->state = 'form';
        $this->resetForm();
    }

    #[On('openFeedbackForm')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->state = 'form';
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->state = 'form';
        $this->resetForm();
        $this->dispatch('closeFeedbackForm');
    }

    public function submit()
    {
        $validated = $this->validate();

        try {
            Mail::to(config('mail.feedback_recipient', 'office@landgrou.com'))
                ->send(new FeedbackFormSubmitted($validated));

            $this->state = 'success';
            $this->resetForm();
            session()->flash('message', __('messages.feedback_form.submitted'));
            $this->dispatch('formSubmitted');
        } catch (\Exception $e) {
            Log::error('Feedback form submission failed', [
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
        $this->reset(['name', 'phone', 'comment', 'privacyAgreement']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.components.feedback-form-block');
    }
}

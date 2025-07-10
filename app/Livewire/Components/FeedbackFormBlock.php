<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackFormSubmitted;
use App\Settings\GlobalSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function mount()
    {
        $this->isOpen = false;
        $this->state = 'form';
        $this->resetForm();
        Log::info('FeedbackFormBlock mounted');
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
            $settings = app(GlobalSettings::class);
            Mail::to($settings->contact_email ?? config('mail.feedback_recipient', 'office@landgrou.com'))
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

    private function resetForm()
    {
        $this->reset(['name', 'phone', 'comment', 'privacyAgreement']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $settings = app(GlobalSettings::class);
        Log::info('Global Settings in FeedbackFormBlock', $settings->toArray());

        return view('livewire.components.feedback-form-block', [
            'settings' => [
                'feedback_form_title' => $settings->feedback_form_title[app()->getLocale()] ?? __('messages.feedback_form.title'),
                'feedback_form_description' => $settings->feedback_form_description[app()->getLocale()] ?? __('messages.feedback_form.description'),
                'feedback_form_image' => $settings->feedback_form_image ? Storage::url($settings->feedback_form_image) : null,
                'feedback_form_image_alt' => $settings->feedback_form_image_alt[app()->getLocale()] ?? __('messages.feedback_form.image_alt'),
            ],
        ]);
    }
}

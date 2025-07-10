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

    protected $settingsCache = null;

    public function mount()
    {
        $this->isOpen = false;
        $this->state = 'form';
        $this->resetForm();
        Log::info('FeedbackFormBlock mounted', ['isOpen' => $this->isOpen, 'state' => $this->state]);
    }

    #[On('openFeedbackForm')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->state = 'form';
        $this->resetForm();
        Log::info('Feedback form opened');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->state = 'form';
        $this->resetForm();
        $this->dispatch('closeFeedbackForm');
        Log::info('Feedback form closed');
    }

    public function submit()
    {
        $validated = $this->validate();

        try {
            $settings = $this->getSettings();
            Mail::to($settings['contact_email'] ?? config('mail.feedback_recipient', 'office@landgrou.com'))
                ->send(new FeedbackFormSubmitted($validated));

            $this->state = 'success';
            $this->resetForm();
            session()->flash('message', __('messages.feedback_form.submitted'));
            $this->dispatch('formSubmitted');
            Log::info('Feedback form submitted successfully', ['validated' => $validated]);
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
        Log::info('Feedback form try again');
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

    private function getSettings()
    {
        if ($this->settingsCache === null) {
            $settings = app(GlobalSettings::class);
            $locale = app()->getLocale();
            $this->settingsCache = [
                'feedback_form_title' => $settings->feedback_form_title[$locale] ?? __('messages.feedback_form.title'),
                'feedback_form_description' => $settings->feedback_form_description[$locale] ?? __('messages.feedback_form.description'),
                'feedback_form_image' => $settings->feedback_form_image ? Storage::url($settings->feedback_form_image) : null,
                'contact_email' => $settings->contact_email,
            ];
            Log::info('Global Settings loaded', $this->settingsCache);
        }
        return $this->settingsCache;
    }

    public function render()
    {
        return view('livewire.components.feedback-form-block', [
            'settings' => $this->getSettings(),
        ]);
    }
}

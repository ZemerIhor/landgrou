<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $subject;
    public $formMessage;
    public $rating;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->subject = $data['subject'];
        $this->formMessage = $data['formMessage'];
        $this->rating = $data['rating'];
    }

    public function build()
    {
        return $this->view('emails.contact-form')
            ->subject('New Contact Form Submission');
    }
}

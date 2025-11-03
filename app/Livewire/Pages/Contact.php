<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Mail\ContactAdminMail;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Mail\ContactCitizenMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact as ContactModel;

class Contact extends Component
{
    public $subject, $first_name, $last_name, $phone, $email, $message;

    protected $rules = [
        'subject' => 'nullable|string|max:255',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:12',
        'email' => 'required|email|max:255',
        'message' => 'required|string|max:5000',
    ];

    protected $messages = [
        'subject.max' => 'Subject cannot exceed 255 characters.',
        'first_name.required' => 'First name is required.',
        'last_name.required' => 'Last name is required.',
        'phone.max' => 'Phone number cannot exceed 12 characters.',
        // 'phone.regex' => 'Please provide a valid phone number.',
        'email.required' => 'Email is required.',
        'email.email' => 'Please provide a valid email address.',
        'message.required' => 'Message is required.',
    ];

    public function submitContactForm()
    {

        $data = $this->validate();

        $sanitizedData = [
            'subject' => $this->sanitizeInput($data['subject']),
            'first_name' => $this->sanitizeInput($data['first_name']),
            'last_name' => $this->sanitizeInput($data['last_name']),
            'phone' => $this->sanitizeInput($data['phone']),
            'email' => $this->sanitizeInput($data['email']),
            'message' => $this->sanitizeInput($data['message']),
        ];

        $this->saveContactForm(
            $sanitizedData['subject'],
            $sanitizedData['first_name'],
            $sanitizedData['last_name'],
            $sanitizedData['phone'],
            $sanitizedData['email'],
            $sanitizedData['message']
        );

        $this->reset(['subject','first_name', 'last_name', 'email', 'message']);

        Mail::to($sanitizedData['email'])->send(new ContactCitizenMail($sanitizedData));

        // // Send email to admin
        // $adminEmail = config('mail.admin_email', 'admin@gmail.com');
        // Mail::to($adminEmail)->send(new ContactAdminMail($sanitizedData));

        session()->flash('success', 'Thank you for contacting us! We will get back to you soon.');
    }


    protected function saveContactForm($subject,$first_name, $last_name, $phone, $email, $message)
    {
        return ContactModel::create([
            'subject' => $subject,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
            'message' => $message,
        ]);
    }


    protected function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags($input));
    }


    #[Layout('layouts.app')]
    #[Title('Contact')]
    public function render()
    {
        return view('livewire.pages.contact');
    }
}

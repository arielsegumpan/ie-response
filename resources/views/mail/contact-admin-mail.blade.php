<x-mail::message>
# New Contact Form Submission

You have received a new contact form submission.

**Contact Details:**

- **Name:** {{ $contactData['first_name'] }} {{ $contactData['last_name'] }}
- **Email:** {{ $contactData['email'] }}
- **Phone:** {{ $contactData['phone'] ?? 'N/A' }}
@if($contactData['subject'])
- **Subject:** {{ $contactData['subject'] }}
@endif

**Message:**
{{ $contactData['message'] }}

@component('mail::button', ['url' => config('app.url')])
View Dashboard
@endcomponent

Thanks,
{{ config('app.name') }}
</x-mail::message>

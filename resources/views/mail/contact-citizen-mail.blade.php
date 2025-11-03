<x-mail::message>
# Thank You for Contacting Us

Dear {{ $contactData['first_name'] }} {{ $contactData['last_name'] }},

Thank you for reaching out to us. We have received your message and will get back to you as soon as possible.

**Your Message Details:**

@if($contactData['subject'])
**Subject:** {{ $contactData['subject'] }}
@endif

**Message:**
{{ $contactData['message'] }}

We appreciate your interest and will respond within 24-48 hours.

Best regards,
{{ config('app.name') }}
</x-mail::message>

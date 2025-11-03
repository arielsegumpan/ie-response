<x-mail::message>
# 👋 Welcome to IE-Response — Your Journey Begins Here!

Dear {{ $name }},

Welcome aboard! 🎉 We're thrilled to have you join IE-Response as a Responder Volunteer. Your decision to step up and serve your community means the world to us — and to those who will benefit from your time, energy, and compassion.

## 🌟 What to Expect

As a Responder Volunteer, you’ll be part of a dynamic network of individuals committed to making a real difference. Whether you're assisting during emergencies, supporting logistics, or providing vital information, your role is essential to our mission.

Here’s what’s coming up:
- **Orientation & Training**: We’ll guide you through everything you need to know.
- **Team Connection**: Meet your fellow volunteers and coordinators.
- **Deployment Readiness**: Get equipped with tools and resources to respond effectively.

## 🧭 Next Steps

1. **Check your inbox** for your onboarding schedule.
2. **Join our community platform** to stay connected and informed.
3. **Reach out anytime** — we’re here to support you.

## 🙌 Thank You

## Account
**Your role:** {{ ucwords(str_replace('_', ' ', $role)) }} <br>
**Your temporary password:** {{ $temporaryPassword }}

Your commitment to service inspires us. Together, we’ll build resilience, offer hope, and respond with heart.

<x-mail::button :url="''">
Reset Password
</x-mail::button>

Warm regards,<br>
**The IE-Response Team**<br>

[www.ie-response.org]({{ config('app.url') }}) <br>
📧 support@ie-response.org
</x-mail::message>






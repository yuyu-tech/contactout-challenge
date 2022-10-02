@component('mail::message')
{{ $firstName }} has been using ContactOut, and thinks it could be of use for you.

Here’s their invitation link for you: [Registration Link]({{ $referLink }})

ContactOut gives you access to contact details for about 75% of the world’s professionals.

Great for recruiting, sales, and marketing outreach.

It’s an extension that works right on top of LinkedIn.

Here’s their invitation link again: [Registration Link]({{ $referLink }})

Thanks,<br>
{{ config('app.name') }}
@endcomponent

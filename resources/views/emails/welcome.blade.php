@component('mail::message')
# Hello {{ $user->first_name }} {{ $user->last_name }}

Welcome to our website.

@component('mail::button', ['url' => ''])
MyCalendar
@endcomponent

Thanks for trusting us<br>
@endcomponent
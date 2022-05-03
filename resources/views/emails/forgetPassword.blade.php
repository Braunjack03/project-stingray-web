@component('mail::message')
# Forgot your password?
  
No problem! To reset your password, click on the link or paste it into your browser.

@component('mail::panel')
[{{url("reset-password/{$token}")}}]({{ url("reset-password/{$token}") }})
@endcomponent

@endcomponent
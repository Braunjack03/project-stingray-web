@component('mail::message')
# Forgot your password?
  
No problem! Click on the button below to reset your password.

@component('mail::button', ['url' => url("reset-password/{$token}")])
Reset My Password
@endcomponent
 
@endcomponent
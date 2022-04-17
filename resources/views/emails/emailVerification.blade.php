@component('mail::message')
# Verify Your Email Address
  
As an extra security measure, please verify this is the correct email address for your Made in Tampa account.

@component('mail::button', ['url' => url("account/verify/{$token}")])
Confirm Email
@endcomponent
 


@endcomponent
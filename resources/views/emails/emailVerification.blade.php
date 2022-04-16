<h1>Verify Your Email Address</h1>
  
<p>As an extra security measure, please verify this is the correct email address for your Made in Tampa account.</p>
<p>

@component('mail::button', ['url' => route('user.verify', $token)])
Confirm Email
@endcomponent
 


</p>

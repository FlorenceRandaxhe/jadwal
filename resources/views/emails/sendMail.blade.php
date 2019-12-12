@component('mail::message')

  {{$session->mail}}

  Cliquez sur le lien suivant pour accéder à votre formulaire :
  @component('mail::button', ['url' => config('app.url') . '/modals/' . $token])
    Remplir mon formulaire
  @endcomponent

  {{$user->name}}
@endcomponent

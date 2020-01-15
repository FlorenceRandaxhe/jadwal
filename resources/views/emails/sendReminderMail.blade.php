@component('mail::message')

Bonjour,

Ceci est un mail de rappel concernant les **modalités d'examen pour la session de {{$session->title}}**
Afin de travailler dans les meilleures conditions, il est impératif de renvoyer votre liste d'examens avant le **{{$session->limit_date->format('d/m/Y')}}**

Cliquez sur le lien suivant pour accéder à votre formulaire :
@component('mail::button', ['url' => config('app.url') . '/modals/' . $token])
Remplir mon formulaire
@endcomponent
Bonne journée,

{{$user->name}}
@endcomponent

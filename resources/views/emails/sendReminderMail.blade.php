@component('mail::message')

Ceci est un mail de rappel concerant les modalités d'examens pour la session de {{$session->title}}
Afin de travailler dans les meilleures conditions, il est impératif de renvoyer votre liste d'examen avant le {{$session->limit_date->format('d/m/Y')}}

Cliquez sur le lien suivant pour accéder à votre formulaire :
@component('mail::button', ['url' => config('app.url') . '/modals/' . $token])
Remplir mon formulaire
@endcomponent

@endcomponent

@component('mail::message')

    @component('mail::button', ['url' => config('app.url') . '/modals/' . $token])
        Remplir mon formulaire
    @endcomponent

@endcomponent

@extends('layouts.app-login')

@section('content')
    <div class="section__home__wrapper">
        <p class="section__home__intro">Jadwal est un outil destiné à la collecte des préférences des professeurs en matière d’organisation des horaires d’examen.</p>
        <div class="section__home__links">
            @guest
                <a class="btn btn--red" href="{{ route('login') }}">Connexion</a>
                @if (Route::has('register'))
                <a class="btn btn--dark-purple" href="{{ route('register') }}">Inscription</a>
                @endif
            @else
                <a class="btn btn--dark-purple" href="/sessions">
                    Dashboard
                </a>
            @endguest
        </div>
    </div>
@endsection




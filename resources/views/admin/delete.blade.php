@extends('layouts.app')
@section('title', 'Supprimer la session')
@section('content')
    <section class="section__single section">
        <div class="wrapper delete__session">
            <div class="delete__session__container">
                <h2 class="delete__title">Attention&nbsp;!</h2>
                <p class="">Êtes-vous sûr de vouloir supprimer la session <span class="text--bold">{{ $session->title }}</span> ? Si vous continuez, vous perdrez également toutes les modalités d'examens liées à cette session.</p>

                <div class="delete__form__container">
                    <a class="btn btn--purple btn--small btn--wide" href="/sessions/{{ $session->id }}">Retour à la session</a>

                 <form action="/sessions/{{$session->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn--red btn--small btn--wide">Supprimer la session</button>
                </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <div class="wrapper">
    <section>
        <div class="dashboard__header">
            <h2 class="dashboard__title">Dashboard</h2>
            <p class="auth__name">Bonjour, {{ Auth::user()->name }}</p>
        </div>
        <section class="card__sessions">
            @if(count($examSessions) > 0)
            <h3>Mes sessions</h3>

            <ul class="card__sessions__list">
                @foreach($examSessions as $examSession)
                <li class="card__session__dashboard">

                    <a class="link__full" href="/sessions/{{$examSession->id}}"><span class="sr_only">Voir la session de {{$examSession->title}}</span></a>
                    <div class="dashboard__session__body">
                        <div>
                            <p class="card__sessions__title">
                                Session&nbsp;: {{$examSession->title}}
                            </p>

                            <p class="card__sessions__date">
                                Date limite&nbsp;: <time datetime="{{$examSession->limit_date}}">{{$examSession->limit_date->format('d/m/Y')}}</time>
                                <span>({{$examSession->limit_date->diffForHumans()}})</span>
                            </p>
                        </div>
                        @if ($examSession->is_complete)
                            <div class="card__sessions__status card__sessions__status--close">
                                <p class="card__sessions__status__text card__sessions__status__text--close">Session cloturée</p>
                            </div>
                        @elseif (!$examSession->is_complete && !$examSession->mail_send)
                            <div class="card__sessions__status card__sessions__status--awaiting">
                                <p class="card__sessions__status__text card__sessions__status__text--awaiting">Mail non envoyé</p>
                            </div>
                        @elseif (!$examSession->is_complete && $examSession->mail_send)
                            <div class="card__sessions__status card__sessions__status--active">
                                <p class="card__sessions__status__text card__sessions__status__text--active">Session active</p>
                            </div>
                        @endif
                    </div>
                </li>

                @endforeach
            </ul>
                {{ $examSessions->links() }}

            @else
                <div class="div__empty box__container">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="200" viewBox="0 0 240.84 190.45">
                            <g>
                                <g>
                                    <circle class="logo__login__circle" cx="120.71" cy="78.4" r="75.9" />
                                    <rect class="logo__login__rec" x="81.93" y="57.07" width="77.56" height="47.65" />
                                    <rect class="logo__login__rec" x="81.93" y="57.07" width="77.56" height="14.2" />
                                    <line class="logo__login__line" x1="120.81" y1="49.04" x2="120.81" y2="62.33" />
                                    <line class="logo__login__line" x1="105.8" y1="49.04" x2="105.8" y2="62.33" />
                                    <line class="logo__login__line" x1="90.78" y1="49.04" x2="90.78" y2="62.33" />
                                    <line class="logo__login__line" x1="135.82" y1="49.04" x2="135.82" y2="62.33" />
                                    <line class="logo__login__line" x1="150.83" y1="49.04" x2="150.83" y2="62.33" />
                                </g>
                            </g>
                        </svg>
                    </div>
                    <h3 class="title__empty">Bienvenue sur Jadwal</h3>
                    <p>Votre outil destiné à la collecte des préférences des professeurs en matière d’organisation des horaires d’examen.</p>
                    <p>Vous n'avez pas encore de session d'examen, commencer par en créer une ou ajouter des professeurs.</p>

                    <div class="div__empty__links">
                        <a class="btn btn--purple" href="/teachers">Ajouter des professeurs</a>
                        <a class="btn btn--purple" href="/sessions/create">Créer une session</a>
                    </div>
                </div>
            @endif
        </section>
    </section>
    </div>
@endsection

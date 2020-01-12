@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <div class="wrapper">
    <section>
        <div class="dashboard__header">
            <h2 class="dashboard__title">Dashboard</h2>
            <div class="notif__wrapper @if(count($notifications) > 0) yes @endif">
                <p class="auth__name">Bonjour, {{ Auth::user()->name }}</p>
                <button class="btn__notif notif__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </button>
                <div class="notifs notifs__container">
                    <h3 class="notifs__title">Notifications</h3>
                    <ul class="notifs__list">
                        @forelse($notifications as $notification)
                    <li class="notifs__list__item"><span class="text--bold">{{ $notification->data['teacher'] }}</span> a envoyé ses modalités d'examens pour la session de {{ $notification->data['session'] }}</p>
                @empty
                <li class="no__notif">Vous n'avez aucunes notifications</p>
                @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <section class="card__sessions">
            @if(count($sessions) > 0)
            <h3>Mes sessions</h3>

            <ul class="card__sessions__list">
                @foreach($sessions as $session)
                <li class="card__session__dashboard">

                    <a class="link__full" href="/sessions/{{$session->id}}"><span class="sr_only">Voir la session de {{$session->title}}</span></a>
                    <div class="dashboard__session__body">
                        <div>
                            <p class="card__sessions__title">
                                Session&nbsp;: {{$session->title}}
                            </p>

                            <p class="card__sessions__date">
                                Date limite&nbsp;: <time datetime="{{$session->limit_date}}">{{$session->limit_date->format('d/m/Y')}}</time>
                                <span>({{$session->limit_date->diffForHumans()}})</span>
                            </p>
                        </div>
                    
                        @if ($session->is_complete)
                            <div class="card__sessions__status card__sessions__status--close">
                                <p class="card__sessions__status__text card__sessions__status__text--close">Session cloturée</p>
                            </div>
                        @elseif (!$session->is_complete && !$session->mail_send)
                            <div class="card__sessions__status card__sessions__status--awaiting">
                                <p class="card__sessions__status__text card__sessions__status__text--awaiting">Mail non envoyé</p>
                            </div>
                        @elseif (!$session->is_complete && $session->mail_send)
                            <div class="card__sessions__status card__sessions__status--active">
                                <p class="card__sessions__status__text card__sessions__status__text--active">Session active</p>
                            </div>
                        @endif
                    </div>
                </li>

                @endforeach
            </ul>
                {{ $sessions->links() }}

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
                    <p>Commencez par ajouter des professeurs, puis créez une session d'examen.</p>

                    <div class="div__empty__links">
                        <a class="btn btn--purple" href="/teachers">Ajouter des professeurs</a>
                    </div>
                </div>
            @endif
        </section>
    </section>
    </div>
@endsection

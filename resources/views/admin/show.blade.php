@extends('layouts.app')
@section('title', ' Session ')
@section('content')
    <div class="wrapper">
        <section class="section__single section">

            @if(session('new_session'))
                <div class="notif notif--success">
                    <p>{{session('new_session')}}</p>
                </div>
            @endif

            @if(session('mail_send'))
                <div class="notif notif--success">
                    <p>{{session('mail_send')}}</p>
                </div>
            @endif

            @if(session('remiderMail_send'))
                <div class="notif notif--success">
                    <p>{{session('remiderMail_send')}}</p>
                </div>
            @endif

            <div class="box__container ">
                <div class="grid__parent">

                    <div class="one">
                        <h2 class="card__sessions__title">Session&nbsp;: {{$examSession->title}}</h2>
                        <p class="card__sessions__date">Date limite&nbsp;: <time datetime="{{$examSession->limit_date}}">{{$examSession->limit_date->format('d/m/Y')}}</time></p>
                    </div>

                    @if ($examSession->is_complete)
                        <div class="two card__sessions__status card__sessions__status--close">
                            <p class="card__sessions__status__text card__sessions__status__text--close">Session cloturée</p>
                        </div>
                    @elseif (!$examSession->is_complete && !$examSession->mail_send)
                        <div class="two card__sessions__status card__sessions__status--awaiting">
                            <p class="card__sessions__status__text card__sessions__status__text--awaiting">Mails non envoyés</p>
                        </div>
                    @elseif (!$examSession->is_complete && $examSession->mail_send)
                        <div class="two card__sessions__status card__sessions__status--active">
                            <p class="card__sessions__status__text card__sessions__status__text--active">Session active</p>
                        </div>
                    @endif

                    <div class="three">
                        <div class="card__sessions__mail">
                            <span class="text--bold">Contenu du mail&nbsp;: </span>
                            {{\Illuminate\Mail\Markdown::parse($examSession->mail)}}

                            <div class="links__container">
                                @if(!$examSession->mail_send)
                                <a class="btn btn--small btn--dark-purple" href="/sessions/{{$examSession->id}}/edit">Modifier l'email</a>
                                @endif
                                <a target="_blank" class="btn btn--small btn--purple" href="/sessions/{{$examSession->id}}/preview">Prévisualiser l'email</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="section__single__teacher">
            <div class="box__container">
                <h2>
                    Liste des destinataires
                </h2>
                <ul class="list__teachers">
                    @foreach($examSession->teachers as $teacher)
                        <li class="list__teachers__item ">
                            <p>
                                {{$teacher->name}}
                            </p>
                            <p>
                                {{$teacher->email}}
                            </p>

                            @if ($examSession->mail_send === 0)
                                <form action="/teachers/{{$teacher->id}}/detach" method="POST" class="list__teachers__form">
                                    @csrf
                                    <input type="hidden" name="teacherId" value="{{$teacher->id}}">
                                    <button class="btn--icon">
                                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                           <span>Retirer</span>
                                    </button>
                                </form>
                            @endif
                            @if ($examSession->mail_send === 1)
                                @if($teacher->pivot->complete_modals == 1)
                                    <a href="/teachers/{{$teacher->id}}" class="reply__active">Voir les modalités</a>
                                @else
                                    <span class="reply__close">En attente</span>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
        @if ($examSession->mail_send === 0)
        <section>
            <h2 class="title__secondary">Ajouter un destinataire</h2>
            <div class="box__container">
                <form action="/teachers/attach" method="POST" class="form_teacher_container">
                    @csrf
                    <input type="hidden" name="sessionId" value="{{$examSession->id}}">
                    <div class="form__div name">
                        <label class="form__label--block" for="name">Nom</label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form__input form__input--wide @error('name') is-invalid @enderror"
                               placeholder="">
                        @error('name')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form__div mail">
                        <label class="form__label--block" for="email">E-mail</label>
                        <input type="mail"
                               id="email"
                               name="email"
                               class="form__input form__input--wide @error('email') is-invalid @enderror"
                               placeholder="">
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form__div">
                        <button class="btn btn--purple icon__container">
                            <svg class="icon__right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                            <span>Ajouter</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
        @endif
        <div class="section__single__form">
            @if ($examSession->is_complete === 0)
            <form action="/sessions/{{$examSession->id}}/complete" method="post">
                @csrf
                @method('PUT')
                <button @if($examSession->mail_send === 0) disabled @endif class="btn @if($examSession->mail_send === 0)btn--disabled @else btn--red @endif">
                    Cloturer la session
                </button>
            </form>
            @endif
            @if ($examSession->mail_send === 0)
            <form action="/sessions/{{$examSession->id}}/send" method="post">
                @csrf
                @method('PUT')
                <button class="btn btn--purple icon__container">
                    <svg class="icon__right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Envoyer les e-mails
                </button>
            </form>
            @elseif($examSession->is_complete === 0)
            <form action="/sessions/{{$examSession->id}}/reminder" method="post">
                @csrf
                @method('PUT')
                <button class="btn btn--purple icon__container">
                    <svg class="icon__right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Envoyer un e-mail de rappel
                </button>
            </form>
            @endif
        </div>

    </div>
@endsection

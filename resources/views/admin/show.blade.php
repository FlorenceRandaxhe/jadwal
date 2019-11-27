@extends('layouts.app')
@section('title', ' Session ')
@section('content')
    <div class="wrapper">
        <section class="section__single section">
            <div class="box__container ">
                <div class="grid__parent">
                    <div class="one">
                        <p class="card__sessions__title">
                            Session&nbsp;: {{$examSession->title}}
                        </p>

                        <p class="card__sessions__date">
                            Date limite&nbsp;: <time datetime="{{$examSession->limit_date}}">{{$examSession->limit_date->format('d/m/Y')}}</time>
                        </p>

                    </div>
                    @if ($examSession->is_complete)
                        <div class="two card__sessions__status card__sessions__status--close">
                            <p class="card__sessions__status__text card__sessions__status__text--close">Session cloturée</p>
                        </div>
                    @elseif (!$examSession->is_complete && !$examSession->mail_send)
                        <div class="two card__sessions__status card__sessions__status--awaiting">
                            <p class="card__sessions__status__text card__sessions__status__text--awaiting">Mail non envoyé</p>
                        </div>
                    @elseif (!$examSession->is_complete && $examSession->mail_send)
                        <div class="two card__sessions__status card__sessions__status--active">
                            <p class="card__sessions__status__text card__sessions__status__text--active">Session active</p>
                        </div>
                    @endif
                    <div class="three">
                        <p class="card__sessions__mail">
                            {{$examSession->mail}}
                        </p>
                    </div>

                </div>
            </div>
        </section>
        <section class="section__single__teacher">
            <div class="box__container">
                <h2>
                    Les professeurs
                </h2>
                <div class="list__teachers">
                    @foreach($examSession->teachers as $teacher)
                        <div class="list__teachers__item ">

                            <div>
                                <a href="/modals/{{$examSession->id}}">{{$teacher->name}}</a>
                                @if ($examSession->mail_send === 0)
                                    <form action="/detach" method="POST" class="list__teachers__form">
                                        @csrf
                                        <input type="hidden" name="teacherId" value="{{$teacher->id}}">
                                        <input type="hidden" name="sessionId" value="{{$examSession->id}}">
                                        <button class="btn btn--icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#636b6f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                            <span>Supprimer</span>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            @foreach($modals as $modal)
                                @if($modal->teacher_id === $teacher->id)
                                <ul class="modals__list">
                                    <li class="modals__list__item">{{$modal->courses}}</li>
                                    <li class="modals__list__item">{{$modal->groups}}</li>
                                    <li class="modals__list__item">{{$modal->exam_type}}</li>
                                    <li class="modals__list__item">{{$modal->local}}</li>
                                    <li class="modals__list__item">{{$modal->exam_duration}}</li>
                                    <li class="modals__list__item">{{$modal->supervisor}}</li>
                                    <li class="modals__list__item">{{$modal->requests}}</li>
                                </ul>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @if ($examSession->mail_send === 0)
        <section>
            <h2 class="title__secondary">Ajouter un professeur</h2>
            <div class="box__container">
                <form action="/attach" method="POST" class="form_teacher_container">
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
                        <button class="btn btn--purple">Ajouter le professeur</button>
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
                <button class="btn btn--purple">
                    Envoyer les e-mails
                </button>
            </form>
            @endif
        </div>

    </div>
@endsection

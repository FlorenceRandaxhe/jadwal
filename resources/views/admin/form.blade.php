@extends('layouts.app')
@section('title', ' Session ')
@section('content')
    <div class="wrapper">
        <section class="section__single section">
            <h2 class="card__sessions__title"><a href="/sessions">Mes session</a> / <a href="/sessions/{{$session->id}}">{{$session->title}}</a> / Prévisualisation</h2>
            <div class="box__container ">
                <div class="grid__parent">

                    <div class="one">
                        <p class="card__sessions__date">Date limite&nbsp;: <time datetime="{{$session->limit_date}}">{{$session->limit_date->format('d/m/Y')}}</time></p>
                        <p class="card__sessions__date">Début des examens&nbsp;: <time datetime="{{$session->exam_start}}">{{$session->exam_start->format('d/m/Y')}}</time></p>
                        <p class="card__sessions__date">Fin des examens&nbsp;: <time datetime="{{$session->exam_finish}}">{{$session->exam_finish->format('d/m/Y')}}</time></p>
                    </div>

                    <div class="three">
                        <div class="card__sessions__mail">
                            <span class="text--bold">Contenu du mail&nbsp;: </span>
                            {{\Illuminate\Mail\Markdown::parse($session->mail)}}

                        </div>
                    </div>
                </div>
            </div>
            <section class="section__single section">
                <form action="" method="POST" class="form box__container">
                    <h3 class="title__secondary">Formulaire à remplir par les professeurs</h3>
                    <div class="grid__container">
                        <div class="form__div grid_a">
                            <label for="courses" class="form__label form__label--block">Intitulé <span class="text--bold">exact</span> du cours</label>
                            <input value="" type="text" name="courses" id="courses" placeholder="Ex&nbsp;: Le suicide par la pratique - Théorie" class="form__input form__input--wide">
                        </div>

                        <div class="form__div grid_b">
                            <label for="groups" class="form__label form__label--block">Groupe(s)</label>
                            <input value="" type="text" name="groups" id="groups" placeholder="Ex&nbsp;: 2181-2182" class="form__input form__input--wide">
                        </div>

                        <div class="form__div grid_c">
                            <label for="exam_type" class="form__label form__label--block">Oral/écrit</label>
                            <input value="" type="text" name="exam_type" id="exam_type" placeholder="Ex&nbsp;: Ecrit" class="form__input form__input--wide">
                        </div>

                        <div class="form__div grid_d">
                            <label for="local" class="form__label form__label--block">Locaux possibles</label>
                            <input value="" type="text" name="local" id="local" placeholder="Ex&nbsp;: L21, L23" class="form__input form__input--wide">

                        </div>

                        <div class="form__div grid_e">
                            <label for="exam_duration" class="form__label form__label--block">Durée de l'examen</label>
                            <input value="" type="text" name="exam_duration" id="exam_duration" placeholder="Ex&nbsp;: 2 heures" class="form__input form__input--wide">
                        </div>

                        <div class="form__div grid_f">
                            <label for="supervisor" class="form__label form__label--block">Surveillants souhaités</label>
                            <input value="" type="text" name="supervisor" id="supervisor" placeholder="Ex&nbsp;: Jean Dupont / 3 surveillants" class="form__input form__input--wide">
                        </div>

                        <div class="form__div grid_g">
                            <label for="requests" class="form__label form__label--block">Groupements / demandes particulières</label>
                            <textarea name="requests" id="requests" rows="5" class="form__textarea--wide" placeholder="Ex&nbsp;: Examen groupé"></textarea>
                        </div>
                    </div>
                </form>
            </section>
            <div class="section__single__form">
                @if ($session->is_complete === 0)
                    <form action="/sessions/{{$session->id}}/complete" method="post">
                        @csrf
                        @method('PUT')
                        <button @if($session->mail_send === 0) disabled @endif class="btn @if($session->mail_send === 0)btn--disabled @else btn--red @endif">
                            Cloturer la session
                        </button>
                    </form>
                @endif
                @if ($session->mail_send === 0)
                    <form action="/sessions/{{$session->id}}/send" method="post">
                        @csrf
                        @method('PUT')
                        <button class="btn btn--purple icon__container">
                            <svg class="icon__right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            Envoyer les e-mails
                        </button>
                    </form>
                @elseif($session->is_complete === 0)
                    <form action="/sessions/{{$session->id}}/reminder" method="post">
                        @csrf
                        @method('PUT')
                        <button class="btn btn--purple icon__container">
                            <svg class="icon__right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            Envoyer un e-mail de rappel
                        </button>
                    </form>
                @endif
            </div>
        </section>
    </div>
@endsection

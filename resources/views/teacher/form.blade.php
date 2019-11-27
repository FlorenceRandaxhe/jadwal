@extends('layouts.app-teacher')
@section('title', 'Ajouter un cours')
@section('content')
        <section class="">
            <div class="wrapper">
                <h2 class="title__secondary">Liste et modalités des examens de janvier 2020</h2>
                <div class="box__container">
                    <p>Période d'examen&nbsp;: du 06/01 au 24/01/2020</p>
                    <p>Dépot TFE le 16/01, défenses le 23/01 pour les réinscriptions</p>

                    <p class="alert--danger">Remarques&nbsp;: afin de travailler dans les meilleures conditions, il est <span class="text--bold">impératif</span> de remplir ce formulaire et de l'envoyer <span class="text--bold">avant le 5 novembre</span> même si ça ne représente rien de particulier</p>
                </div>
            </div>
        </section>

        <section>
            <div class="wrapper">
                <h2 class="title__secondary">Mes cours</h2>
                <div class="box__container">
                    @foreach($modals as $modal)
                    <ul class="list__item">
                        <li>{{$modal->courses}}</li>
                        <li>{{$modal->groups}}</li>
                        <li>{{$modal->local}}</li>
                        <li>{{$modal->exam_type}}</li>
                        <li>{{$modal->exam_duration}}</li>
                        @if($modal->supervisor)<li>{{$modal->supervisor}}</li>@endif
                        @if($modal->requests)<li>{{$modal->requests}}</li>@endif
                    </ul>
                        <form action="/modals/{{$modal->id}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn--pink">Supprimer</button>
                        </form>
                    @endforeach
                    @forelse($modals as $modal)
                        @empty
                        <p>Vous n'avez pas encore enregistrer de cours</p>
                        @endforelse
                </div>
            </div>
        </section>

        <section class="section__schedule section">
            <div class="wrapper">
                <form action="/modals" method="POST" class="form">
                    @csrf
                    <h2 class="title__secondary">Session de septembre 2019</h2>
                    <div class="box__container">
                        <div class="schedule__form__head">
                            <label for="name" class="form__label form__label--in-line">Nom du professeur&nbsp;:</label>
                            <input type="text" name="name" id="name" value="Dominique Villain" class="form__input form__input--light">
                            @error('title')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="schedule__form__content">
                            <div class="">
                                <label for="courses" class="form__label text--bold form__label--block">Intitulé exact du cours</label>
                                <input value="" type="text" name="courses" id="courses" placeholder="Ex&nbsp;: Le suicide par la pratique - Théorie" class="form__input form__input--wide">
                                @error('courses')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="">
                                <label for="groups" class="form__label text--bold form__label--block">Groupe(s)</label>
                                <input value="" type="text" name="groups" id="groups" placeholder="Ex&nbsp;: 2181-2182" class="form__input form__input--wide">
                                 @error('groups')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="">
                                <label for="exam_type" class="form__label text--bold form__label--block">Oral/écrit</label>
                                <input value="" type="text" name="exam_type" id="exam_type" placeholder="Ex&nbsp;: Ecrit" class="form__input form__input--wide">
                                 @error('exam_type')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="">
                                <label for="local" class="form__label text--bold form__label--block">Locaux possibles</label>
                                <input value="" type="text" name="local" id="local" placeholder="Ex&nbsp;: L21, L23" class="form__input form__input--wide">
                                 @error('local')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="">
                                <label for="exam_duration" class="form__label text--bold form__label--block">Durée de l'examen</label>
                                <input value="" type="text" name="exam_duration" id="exam_duration" placeholder="Ex&nbsp;: 2 heures" class="form__input form__input--wide">
                                 @error('exam_duration')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="">
                                <label for="supervisor" class="form__label text--bold form__label--block">Surveillants souhaités</label>
                                <input value="" type="text" name="supervisor" id="supervisor" placeholder="Ex&nbsp;: Jean Dupont" class="form__input form__input--wide">
                            </div>
                        </div>

                        <div class="">
                            <div class="form__cell form__cell--wide">
                                <label for="requests" class="form__label text--bold form__label--block">Demande particulières / indisponibilités / contraintes</label>
                                <textarea name="requests" id="requests" rows="5" class="form__textarea--wide" placeholder="Ex&nbsp;: Si possible, je préférerais que mes examens aient lieux la 2e et 3e semaines"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="btn--right">
                        <button class="btn btn--purple">Envoyer</button>
                    </div>
                </form>
            </div>
        </section>


@endsection
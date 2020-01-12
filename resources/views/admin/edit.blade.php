@extends('layouts.app')
@section('title', 'Modifier une session')
@section('content')

    <div class="flex_container">
        <section class="form__session__container">
            <h2 class="title__secondary">Modifier la session d'examen</h2>
            <form action="/sessions/{{$session->id}}" method="POST" class="form">
                @csrf
                @method('PUT')
                <div class="box__container form__container--grid">

                    <div class="form__div a">
                        <label for="title" class="form__label form__label--block">Session&nbsp;:</label>
                        <input type="text"
                               value="{{$session->title}}"
                               name="title"
                               id="title"
                               class="form__input form__input--wide @error('title') is-invalid @enderror"
                               placeholder="Ex&nbsp;: Septembre 2019">
                        @error('title')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div b">
                        <label for="limit_date" class="form__label form__label--block">Date d'échéance&nbsp;:</label>
                        <input type="date"
                               value="{{$session->limit_date->format('Y-m-d')}}"
                               name="limit_date"
                               id="limit_date"
                               class="form__input form__input--wide @error('limit_date') is-invalid @enderror">
                        @error('limit_date')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div c">
                        <label for="exam_start" class="form__label form__label--block">Date de début des examens&nbsp;:</label>
                        <input type="date"
                               value="{{$session->exam_start->format('Y-m-d')}}"
                               name="exam_start"
                               id="exam_start"
                               class="form__input form__input--wide @error('limit_date') is-invalid @enderror">
                        @error('exam_start')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div d">
                        <label for="exam_finish" class="form__label form__label--block">Date de fin des examens&nbsp;:</label>
                        <input type="date"
                               value="{{$session->exam_finish->format('Y-m-d')}}"
                               name="exam_finish"
                               id="exam_finish"
                               class="form__input form__input--wide @error('limit_date') is-invalid @enderror">
                        @error('exam_finish')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div e">
                        <label for="mail" class="form__label form__label--block">Contenu du mail&nbsp;:</label>
                        <p>#titre, ##sous-titre, **gras**, ***italique***</p>
                        <textarea name="mail"
                                  id="mail"
                                  rows="15"
                                  class="form__textarea--wide @error('mail') is-invalid @enderror">{{$session->mail}}</textarea>
                        @error('mail')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror

                    </div>
                    <div class="form__div f">
                        <a href="/sessions/{{ $session->id }}">Annuler</a>
                        <button class="btn btn--purple">Enregistrer les modifications</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

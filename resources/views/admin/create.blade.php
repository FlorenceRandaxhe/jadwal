@extends('layouts.app')
@section('title', 'Créer une session')
@section('content')

    <div class="flex_container">
            @if(count($formerSessions) > 0)
            <section class="former__sessions">
                <h2 class="former__sessions__title">Repartir d'un ancien mail</h2>
                <ul class="former__sessions__list">
                    @foreach($formerSessions as $formerSession)
                        <li class="former__sessions__item">
                            <a class="former__sessions__link" href="/sessions/create?former={{$formerSession->id}}"></a>
                            <span class="former__sessions__name text--block">{{$formerSession->title}}</span>
                            <span class="text--block">{{$formerSession->limit_date->format('d/m/Y')}}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
            @endif
            <section class="form__session__container">
                <h2 class="title__secondary">Créer une nouvelle session d'examen</h2>

                <form action="/sessions" method="POST" class="form">
                    @csrf
                    <input type="hidden" name="oldSession" value="{{$oldSession ? $oldSession->id : ''}}">
                    <div class="box__container form__container--grid">

                        <div class="form__div a">
                            <label for="title" class="form__label form__label--block">Session&nbsp;:</label>
                            <input type="text"
                                   value="{{$oldSession ? $oldSession->title : ''}}"
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
                                   value="{{$oldSession ? $oldSession->limit_date->format('Y-m-d') : ''}}"
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
                                   value="{{$oldSession ? $oldSession->exam_start->format('Y-m-d') : ''}}"
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
                                   value="{{$oldSession ? $oldSession->exam_finish->format('Y-m-d') : ''}}"
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
                                      class="form__textarea--wide @error('mail') is-invalid @enderror">{{$oldSession->mail ?? ''}}</textarea>
                            @error('mail')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror

                        </div>
                        <div class="form__div f">
                            <a href="/sessions">Annuler</a>
                            <button class="btn btn--purple">Créer la session</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
@endsection

@extends('layouts.app')
@section('title', 'Créer une session')
@section('content')
    <section class="section section__session">
        <div class="wrapper">
            <h2 class="title__secondary">Nouvelle session</h2>
            <form action="/sessions" method="POST" class="form">
                @csrf
                <div class="box__container form__container--grid">

                    <div class="form__div a">
                        <label for="title" class="form__label form__label--block">Session&nbsp;:</label>
                        <input type="text"
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
                        <label for="mail" class="form__label form__label--block">Contenu du mail&nbsp;:</label>
                        <textarea name="mail"
                                  id="mail"
                                  rows="15"
                                  class="form__textarea--wide @error('mail') is-invalid @enderror"></textarea>
                        @error('mail')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form__div d">
                        <p class="alert--info">
                            Lorsque vous créez une session, tous les professeurs qui ont été créer précédement seront automatiquement importé dans la nouvelle session.
                            Après avoir créer la session vous pourrez supprimer ou ajouter des professeurs à la session.
                        </p>
                        <button class="btn btn--purple">Créer la session</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
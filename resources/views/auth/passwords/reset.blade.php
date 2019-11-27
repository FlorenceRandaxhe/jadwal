@extends('layouts.app')
@section('title', 'Réinitialisation du mot de passe')
@section('content')
<section class="section__home">
    <div class="section__home__wrapper">
            <div class="section__home__container box__container">
                <h2 class="login__title">Réinisialiser le mot de passe</h2>
                <form class="login__form" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form__div">
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <label for="email" class="form__label form__label--block">Adresse e-mail</label>
                        <input id="email" type="email" class="form__input--wide form__input--outline @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    </div>

                    <div class="form__div">
                        @error('password')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <label for="password" class="form__label form__label--block">Mot de passe</label>
                        <input id="password" type="password" class="form__input--wide form__input--outline @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    </div>

                    <div class="form__div">
                        <label for="password-confirm" class="form__label form__label--block">Confirmer le mot de passe</label>
                        <input id="password-confirm" type="password" class="form__input--wide form__input--outline" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="form__div">
                            <button type="submit" class="btn btn--purple">
                                Réinisialiser le mot de passe
                            </button>
                    </div>
                </form>
            </div>
    </div>
</section>
@endsection

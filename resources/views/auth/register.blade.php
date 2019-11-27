@extends('layouts.app-login')
@section('title', 'Inscription')
@section('content')
    <section class="section__home">
        <div class="section__home__wrapper">
            <div class="section__home__container box__container">
                <h2 class="login__title">Créer un compte</h2>
                <form method="POST" action="{{ route('register') }}" class="login__form">
                    @csrf
                    <div class="form__div">
                        @error('name')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <label class="form__label form__label--block" for="name">Nom</label>
                        <input id="name"
                               type="text"
                               class="form__input--wide form__input--outline @error('name') is-invalid @enderror"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Morgane Van Moffaert"
                               required autocomplete="name" autofocus>
                    </div>

                    <div class="form__div">
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <label class="form__label form__label--block" for="email">Email</label>
                        <input id="email"
                               type="email"
                               class="form__input--wide form__input--outline @error('email') is-invalid @enderror"
                               name="email"
                               placeholder="exemple@mail.com"
                               value="{{ old('email') }}"
                               required autocomplete="email">
                    </div>

                    <div class="form__div">
                        @error('password')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <label class="form__label form__label--block" for="password">Mot de passe</label>
                        <input id="password"
                               type="password"
                               class="form__input--wide form__input--outline @error('password') is-invalid @enderror"
                               name="password" required autocomplete="new-password">
                    </div>

                    <div class="form__div">
                        <label class="form__label form__label--block" for="password-confirm">Confirmer le mot de passe</label>
                        <input id="password-confirm"
                               type="password"
                               class="form__input--wide form__input--outline"
                               name="password_confirmation"
                               required autocomplete="new-password">
                    </div>

                    <div class="form__div">
                        <button type="submit" class="btn btn--purple">
                            Créer un compte
                        </button>
                        @guest
                            <a href="{{ route('login') }}">Connexion</a>
                        @endguest
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.app-login')
@section('title', 'Connexion')
@section('content')
    <section class="section__home">
        <div class="section__home__wrapper">
            <div class="section__home__container box__container">
                <h2 class="login__title">Se connecter</h2>
                <form method="POST" action="{{ route('login') }}" class="login__form">
                    @csrf
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
                               value="{{ old('email') }}"
                               placeholder="exemple@mail.com"
                               required autocomplete="email" autofocus>
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
                               name="password"
                               required autocomplete="current-password">
                    </div>

                    <div class="form__div">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form__label" for="remember">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div class="form__div">
                        <button class="btn btn--purple" type="submit">
                            Se connecter
                        </button>
                    </div>

                    <div class="form__div">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Mot de passe oublié&nbsp;?
                            </a>
                        @endif
                        @guest
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Inscription</a>
                            @endif
                        @endguest
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
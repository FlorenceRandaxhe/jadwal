@extends('layouts.app-login')
@section('title', 'Mot de passe oublié')
@section('content')
<section class="section__home">
    <div class="section__home__wrapper">
        <div class="section__home__container box__container">
            <h2 class="login__title">Mot de passe oublié</h2>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="login__form" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form__div">
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                        <label for="email" class="form__label form__label--block">Adresse e-mail</label>
                        <input id="email"
                               type="email"
                               class="form__input--wide form__input--outline @error('email') is-invalid @enderror"
                               name="email"
                               placeholder="exemple@mail.com"
                               value="{{ old('email') }}"
                               required autocomplete="email" autofocus>

                    </div>

                    <div class="form__div">
                        <button type="submit" class="btn btn--purple">
                            Envoyer un lien
                        </button>
                    </div>
                </form>


        </div>
    </div>
</section>
@endsection

@extends('layouts.app-login')
@section('title', 'Vérification du mail')
@section('content')
<section class="container">
    <div class="section__home__wrapper">
        <div class="section__home__container box__container">

                <h2 class="login__title">Vérifier votre adresse e-mail</h2>


                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Un lien vous a été envoyé par mail
                        </div>
                    @endif

                    <p>Vérifier si vous avez bien reçu le mail</p>

                    <p>Si vous n'avez pas reçu le mail</p>
                    <form class="login__form" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn--purple">Renvoyer le mail</button>.
                    </form>

        </div>
    </div>
</section>
@endsection

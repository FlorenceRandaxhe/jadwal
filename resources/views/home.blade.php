@extends('layouts.app')
@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

    <section class="section__header section__home">
        <div class="section__home__wrapper">
            <h2 class="title__secondary">Dashboard</h2>
            <a href="/mail">Créer une nouvelle session</a>
        </div>
    </section>

@endsection

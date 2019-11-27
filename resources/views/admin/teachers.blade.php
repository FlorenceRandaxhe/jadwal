@extends('layouts.app')
@section('title', 'Les professeurs')
@section('content')
    <section>
        <div class="wrapper">
            <h2 class="title__secondary">Tous les professeurs</h2>

            <div class="box__container">
                @foreach($teachers as $teacher)
                    <div class="list__teachers__item">
                        <div>
                            <p>
                                {{$teacher->name}}
                            </p>
                            <form action="/teachers/{{$teacher->id}}" method="post" class="list__teachers__form">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn--icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#636b6f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    <span>Supprimer</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
                    @forelse ($teachers as $teacher)
                    @empty
                        <p>Il n'y a pas encore de professeurs</p>
                    @endforelse
            </div>
        </div>
    </section>

    <section>
        <div class="wrapper">
            <h2 class="title__secondary">Ajouter des professeurs</h2>

            <div class="box__container">
                <p class="text--bold form__info">Ajouter un seul professeur</p>
                <form action="/teachers" method="POST" class="form_teacher_container">

                    @csrf
                    <input type="hidden" name="type" value="singleTeacher">
                    <div class="form__div name">
                        <label class="form__label--block" for="name">Nom</label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form__input form__input--wide @error('name') is-invalid @enderror"
                               placeholder="">
                        @error('name')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form__div mail">
                        <label class="form__label--block" for="email">E-mail</label>
                        <input type="mail"
                               id="email"
                               name="email"
                               class="form__input form__input--wide @error('email') is-invalid @enderror"
                               placeholder="">
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form__div">
                        <button class="btn btn--purple">Ajouter le professeur</button>
                    </div>
                </form>
            </div>

            <div class="box__container">
                <p class="text--bold form__info">Importer une liste de professeurs via un fichier CSV</p>
                <form action="/csvfile" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="csv">
                    <div class="form__div">
                        <label class="form__label" for="file">Fichier CSV</label>
                        <input type="file" accept=".csv" name="file" class="form__input--file @error('file') is-invalid @enderror" id="file">
                        @error('file')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form__div">
                        <button type="submit" class="btn btn--purple">Importer le fichier</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
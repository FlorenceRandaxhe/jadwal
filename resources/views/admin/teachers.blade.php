@extends('layouts.app')
@section('title', 'Les professeurs')
@section('content')
    <div class="wrapper">
    @if(session('new_teacher'))
        <div class="notif notif--success">
            <p>{{session('new_teacher')}}</p>
        </div>
    @endif
        <section>
            <h2 class="title__secondary">Tous les professeurs</h2>
            @if(session('modal_awaiting'))
                <div class="alert alert--danger">
                    {{session('modal_awaiting')}}
                </div>
            @endif
            <div class="box__container">
                @forelse ($teachers as $teacher)
                    <div class="list__teachers__item">
                            <p>
                                {{$teacher->name}}
                            </p>
                            <p>
                                {{$teacher->email}}
                            </p>
                            <form action="/teachers/{{$teacher->id}}" method="post" class="list__teachers__form">
                                @csrf
                                @method('DELETE')
                                <button class="btn--icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#636b6f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    <span>Supprimer</span>
                                </button>
                            </form>
                    </div>
                @empty
                    <p>Il n'y a pas encore de professeur</p>
                @endforelse
            </div>
        </section>

        <section>
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
                        <button class="btn btn--purple icon__container">
                            <svg class="icon__right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                            <span>Ajouter</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="box__container">
                <p class="text--bold form__info">Importer une liste de professeurs via un fichier CSV</p>
                <form action="/csv" method="POST"  enctype="multipart/form-data">
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
        </section>
    </div>
@endsection

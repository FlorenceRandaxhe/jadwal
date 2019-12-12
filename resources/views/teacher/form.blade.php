@extends('layouts.app-teacher')
@section('title', 'Ajouter des cours')
@section('content')

<div class="wrapper--large">
    @if(session('new_modal'))
        <div class="notif notif--success">
            <p>{{session('new_modal')}}</p>
        </div>
    @endif
    @if(session('duplicate_session'))
        <div class="notif notif--success">
            <p>{{session('duplicate_session')}}</p>
        </div>
    @endif
    @if(session('modal_complete'))
        <div class="notif notif--success">
            <p>{{session('modal_complete')}}</p>
        </div>
    @endif
    <section class="teacher_section">
        <h2 class="title__secondary">Liste et modalités des examens de {{$session->title}} -  {{$teacher->name}}</h2>
        <div class="alert alert--info">
            <p class="alert--head">
                Remarques
            </p>
            <p class="alert--content">
                Afin de travailler dans les meilleures conditions, il est impératif de <span class="text--bold">renvoyer votre liste d'examen avant le {{$session->limit_date->format('d-m-Y')}}</span> même si ça ne représente rien de particulier.
            </p>
            <p class="alert--bottom">
                Pour ce faire, vous pouvez <a class="link--info" href="#one__courses">ajouter des cours</a> un-à-un, ou <a class="link--info" href="#former__sessions">repartir d'une ancienne session</a> d'examen
            </p>
        </div>
    </section>

    <section class="teacher_section">
            <h2>Mes cours pour la session de {{$session->title}}</h2>
            <div class="table__container">
                <div class="table__scroll">
                    <table class="table">
                        <thead>
                        <tr class="table__head">
                            <th class="table__head__data">Cours</th>
                            <th class="table__head__data">Groupe(s)</th>
                            <th class="table__head__data">type d'examen</th>
                            <th class="table__head__data">Local</th>
                            <th class="table__head__data">Durée de l'examen</th>
                            <th class="table__head__data">Superviseur(s)</th>
                            <th class="table__head__data">Demandes particulières</th>
                            <th class="table__head__data"><span class="sr_only">Supprimer la ligne</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($modals as $modal)
                            <tr class="table__row">
                                <td class="table__row__data">{{$modal->courses}}</td>
                                <td class="table__row__data">{{$modal->groups}}</td>
                                <td class="table__row__data">{{$modal->exam_type}}</td>
                                <td class="table__row__data">{{$modal->local}}</td>
                                <td class="table__row__data">{{$modal->exam_duration}}</td>
                                <td class="table__row__data">
                                    @if($modal->supervisor)
                                        {{$modal->supervisor}}
                                    @else
                                        /
                                    @endif
                                </td>
                                <td class="table__row__data">
                                    @if($modal->requests)
                                        {{$modal->requests}}
                                    @else
                                        /
                                    @endif
                                </td>

                                <td class="table__row__data">
                                    @if($pivot->complete_modals == 0)
                                    <form action="/modals/{{$modal->id}}" method="POST" class="">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn--icon icon__container">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            <span>Supprimer</span>
                                        </button>
                                    </form>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @forelse($modals as $modal)
                    @empty
                        <p class="empty__courses">
                            Vous n'avez pas encore ajouté d'examen&nbsp;! <a class="link--info" href="#one__courses">Ajouter des cours</a> un-à-un, ou <a class="link--info" href="#former__sessions">repartir d'une ancienne session</a>
                        </p>
                    @endforelse
                </div>
            </div>
            @if($pivot->complete_modals == 0)
                <form class="btn__container" action="/modals/{{$pivot->token}}/complete" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="alert alert--danger">
                        <p class="alert--head">Attention&nbsp;!</p>
                        <p class="alert--content">Une fois que vous aurez marqué la session comme terminée vous ne pourrez plus ajouter de nouvel examen à la session.</p>
                        <p class="alert--content">N'oubliez pas d'<span class="text--bold">envoyer votre liste de cours lorsque vous avez fini</span>, sinon l'horairiste n'aua pas accès à vos préférences</p>
                    </div>
                    <button class="btn btn--red">
                        Envoyer ma liste d'examens
                    </button>
                </form>
            @endif
        </section>

    @if($pivot->complete_modals == 0)
    <section id="former__sessions" class="teacher_section">
        <h2 class="title__secondary">Mes anciennes sessions</h2>
        <div class="former__modals__list">
            @foreach($oldSessions as $oldSession)
                <div class="former__modals__item">
                    <div>
                        <p class="text--bold">{{$oldSession->title}}</p>
                        <ul class="former__modals__courses__list">
                            @foreach($oldSession->oldmodals as $oldmodals)
                                @if($oldmodals->teacher_id == $teacher->id)
                                    <li class="former__modals__courses__item">{{$oldmodals->courses}}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <form method="POST" action="/modals/{{$oldSession->id}}/duplicate">
                        @csrf
                        <input type="hidden" value="{{$session->id}}" name="session_id">
                        <input type="hidden" value="{{$teacher->id}}" name="teacher_id">
                        <button class="btn btn--small btn--purple">Repartir de cette session</button>
                    </form>
                </div>
            @endforeach
            @forelse($oldSessions as $oldSession)
            @empty
                <p>Vous n'avez pas encore de session</p>
            @endforelse
        </div>
    </section>
    @endif

    @if($pivot->complete_modals == 0)
        <section id="one__courses" class="teacher_section">
            <form action="/modals" method="POST" class="form">
                @csrf
                <h2 class="title__secondary">Ajouter un examen</h2>
                <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                <input type="hidden" name="session_id" value="{{$session->id}}">
                <div class="box__container grid__container">
                    <div class="form__div grid_a">
                        <label for="courses" class="form__label form__label--block">Intitulé exact du cours <span class="text--bold">*</span></label>
                        <input value="" type="text" name="courses" id="courses" placeholder="Ex&nbsp;: Le suicide par la pratique - Théorie" class="form__input form__input--wide">
                        @error('courses')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div grid_b">
                        <label for="groups" class="form__label form__label--block">Groupe(s) <span class="text--bold">*</span></label>
                        <input value="" type="text" name="groups" id="groups" placeholder="Ex&nbsp;: 2181-2182" class="form__input form__input--wide">
                        @error('groups')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div grid_c">
                        <label for="exam_type" class="form__label form__label--block">Oral/écrit <span class="text--bold">*</span></label>
                        <input value="" type="text" name="exam_type" id="exam_type" placeholder="Ex&nbsp;: Ecrit" class="form__input form__input--wide">
                        @error('exam_type')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div grid_d">
                        <label for="local" class="form__label form__label--block">Locaux possibles <span class="text--bold">*</span></label>
                        <input value="" type="text" name="local" id="local" placeholder="Ex&nbsp;: L21, L23" class="form__input form__input--wide">
                        @error('local')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div grid_e">
                        <label for="exam_duration" class="form__label form__label--block">Durée de l'examen <span class="text--bold">*</span></label>
                        <input value="" type="text" name="exam_duration" id="exam_duration" placeholder="Ex&nbsp;: 2 heures" class="form__input form__input--wide">
                        @error('exam_duration')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form__div grid_f">
                        <label for="supervisor" class="form__label form__label--block">Surveillants souhaités</label>
                        <input value="" type="text" name="supervisor" id="supervisor" placeholder="Ex&nbsp;: Jean Dupont" class="form__input form__input--wide">
                    </div>

                    <div class="form__div grid_g">
                        <label for="requests" class="form__label form__label--block">Demandes particulières / indisponibilités / contraintes</label>
                        <textarea name="requests" id="requests" rows="5" class="form__textarea--wide" placeholder="Ex&nbsp;: Si possible, je préférerais que mes examens aient lieux la 2e et 3e semaines"></textarea>
                    </div>
                    <p class="mandatory__fields">Les champs suivi d'un <span class="text--bold">*</span> sont obligatoires</p>
                </div>

                <div class="btn--right">
                    <button class="btn btn--purple">Enregistrer le cours</button>
                </div>
            </form>
        </section>
    @endif
</div>


@endsection
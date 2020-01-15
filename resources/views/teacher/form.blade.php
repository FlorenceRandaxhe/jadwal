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
        <h2 class="title__secondary">Modalités d'examen de {{$session->title}} -  {{$teacher->name}}</h2>
        <div class="alert alert--info">
            <p class="alert--head">
                Remarques
            </p>
            <p class="alert--content">Afin de travailler dans les meilleures conditions, il est impératif de <span class="text--bold">renvoyer votre liste d'examens avant le {{$session->limit_date->format('d/m/Y')}}</span> même si ça ne représente rien de particulier.</p>
            <p>Période d'examens&nbsp;: du {{$session->exam_start->format('d/m/Y')}} au {{$session->exam_finish->format('d/m/Y')}}</p>
            <p>Si vous le souhaitez, vous pouvez sauvegarder les cours pour les prochaines sessions</p>
            <p class="alert--bottom"> N'oubliez pas d'<span class="text--bold">envoyer votre liste de cours lorsque vous avez fini</span>, sinon l'horairiste n'aura pas accès à vos préférences.</p>
            <p>Une fois vos modalités envoyées <span class="text--bold">vous ne pourrez plus les modifier</span>, mais vous pourrez toujours consulter cette page.</p>
        </div>
    </section>

    <section class="">
        <div class="dashboard__header">
            <h2>Mes cours pour la session de {{$session->title}}</h2>
            <a target="_blank" class="icon__container btn btn--purple" href="/teachers/{{$teacher->id}}/{{$pivot->token}}/teacherPdf">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon__right"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                <span>Télécharger une version pdf</span>
            </a>
        </div>
        <div class="table__container">
            <div class="table__scroll">
                <table class="table">
                    <thead>
                    <tr class="table__head">
                        <th class="table__head__data">Cours</th>
                        <th class="table__head__data">Groupe(s)</th>
                        <th class="table__head__data">Type d'examen</th>
                        <th class="table__head__data">Local</th>
                        <th class="table__head__data">Durée de l'examen</th>
                        <th class="table__head__data">Superviseur(s)</th>
                        <th class="table__head__data">Demandes particulières</th>
                        @if($pivot->complete_modals == 0)
                        <th class="table__head__data"><span class="sr_only">Supprimer la ligne</span></th>
                        @endif
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
                            @if($pivot->complete_modals == 0)
                            <td class="table__row__data">
                                <form action="/modals/{{$modal->id}}" method="POST" class="">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn--icon icon__container">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        <span>Supprimer</span>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @forelse($modals as $modal)
                @empty
                    <p class="empty__courses">
                        Vous n'avez pas encore ajouté d'examen&nbsp;!
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    @if($pivot->complete_modals == 0)
        <form class="btn__container" action="/modals/{{$pivot->token}}/complete" method="POST">
            @csrf
            @method('PUT')
            <div class="btn--right">
                <button class="btn btn--red">
                    Envoyer ma liste d'examens
                </button>
            </div>
        </form>


        <section>
            <h2 class="title__secondary">Ajouter des cours</h2>
            <div class="teacher__grid__container">

                <div id="former__sessions" class="teacher__grid__container--child-1">
                    <div class="former__modals__list">
                        <div class="former__modals__item">
                            <div class="text--bold">Cours sauvegardés</div>
                            <ul class="former__modals__courses__list">
                                @forelse($oldModals as $oldModal)
                                    <li class="former__modals__courses__item">

                                        <p class="text--bold">{{$oldModal->courses}}</p>

                                        <div class="former__modals__actions">
                                            <a class="save__courses" href="/modals/{{$pivot->token}}?formerModal={{$oldModal->id}}">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></a>

                                       <form method="POST" action="/modals/{{$oldModal->id}}/unsave">
                                            @method('PUT')
                                            @csrf
                                            <button class="save__courses">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg></button>
                                        </form>
                                        </div>
                                    </li>
                                    @empty
                                    <li>Vous n'avez pas encore d'examen sauvegardé</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="one__courses" class="teacher__grid__container--child-2">
                    <form action="/modals" method="POST" class="form box__container">
                        @csrf
                        <input type="hidden" name="teacher_id" value="{{$teacher->id}}">
                        <input type="hidden" name="session_id" value="{{$session->id}}">
                        <div class="grid__container">
                            <div class="form__div grid_a">
                                <label for="courses" class="form__label form__label--block">Intitulé <span class="text--bold">exact</span> du cours <span class="text--bold">*</span></label>
                                <input value="{{$formerModal ? $formerModal->courses : ''}}"
                                       type="text"
                                       name="courses"
                                       id="courses"
                                       placeholder="Ex&nbsp;: Le suicide par la pratique - Théorie"
                                       class="form__input form__input--wide">
                                @error('courses')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form__div grid_b">
                                <label for="groups" class="form__label form__label--block">Groupe(s) <span class="text--bold">*</span></label>
                                <input value="{{$formerModal ? $formerModal->groups : ''}}" type="text" name="groups" id="groups" placeholder="Ex&nbsp;: 2181-2182" class="form__input form__input--wide">
                                @error('groups')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form__div grid_c">
                                <label for="exam_type" class="form__label form__label--block">Oral/écrit <span class="text--bold">*</span></label>
                                <input value="{{$formerModal ? $formerModal->exam_type : ''}}" type="text" name="exam_type" id="exam_type" placeholder="Ex&nbsp;: Ecrit" class="form__input form__input--wide">
                                @error('exam_type')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form__div grid_d">
                                <label for="local" class="form__label form__label--block">Locaux possibles <span class="text--bold">*</span></label>
                                <input value="{{$formerModal ? $formerModal->local : ''}}" type="text" name="local" id="local" placeholder="Ex&nbsp;: L21, L23" class="form__input form__input--wide">
                                @error('local')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form__div grid_e">
                                <label for="exam_duration" class="form__label form__label--block">Durée de l'examen <span class="text--bold">*</span></label>
                                <input value="{{$formerModal ? $formerModal->exam_duration : ''}}" type="text" name="exam_duration" id="exam_duration" placeholder="Ex&nbsp;: 2 heures" class="form__input form__input--wide">
                                @error('exam_duration')
                                <div class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>

                            <div class="form__div grid_f">
                                <label for="supervisor" class="form__label form__label--block">Surveillants souhaités</label>
                                <input value="{{$formerModal ? $formerModal->supervisor : ''}}" type="text" name="supervisor" id="supervisor" placeholder="Ex&nbsp;: Jean Dupont" class="form__input form__input--wide">
                            </div>

                            <div class="form__div grid_g">
                                <label for="requests" class="form__label form__label--block">Groupements / demandes particulières</label>
                                <textarea name="requests" id="requests" rows="5" class="form__textarea--wide" placeholder="Ex&nbsp;: Si possible, je préférerais que mes examens aient lieux la 2e et 3e semaines">{{$formerModal ? $formerModal->requests : ''}}</textarea>
                            </div>
                            <div class="form__div grid_h">
                                <div>
                                    <input type="checkbox" class="form__check" name="save" id="save">
                                    <label for="save">Sauvegarder le cours</label>

                                    <p class="mandatory__fields">Les champs suivis d'un <span class="text--bold">*</span> sont obligatoires</p>
                                </div>
                                <button class="icon__container btn btn--purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon__right"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Ajouter le cours
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    @endif
</div>


@endsection

@extends('layouts.app')
@section('title', ' Session ')
@section('content')

    <div class="wrapper">
        <section>
            <div class="dashboard__header">
                <h2 class="">{{$teacher->name}}</h2>
                <a target="_blank" class="btn btn--purple" href="/teachers/{{$teacher->id}}/pdf">Télécharger une version pdf</a>
            </div>
            <p>{{$teacher->name}} a ajouté {{count($teacher->modals)}} examen(s)</p>

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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teacher->modals as $modal)
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
                            </tr>
                            @if($modal->requests)
                                <tr>
                                    <td colspan="6" class="table__row__data table__row__data--last">
                                        <span class="alert--request">Demande(s) particulière(s) / groupements&nbsp;:</span>
                                        <span>{{$modal->requests}}</span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
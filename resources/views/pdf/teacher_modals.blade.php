<style>
    *{
        font-family: 'Nunito', sans-serif;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table {
        width: 100%;
    }

    .table__head{
        background-color: #dfe4e7;
        text-align: left;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .table__head__data:first-of-type{
        border-radius: 8px 0 0 0;
    }
    .table__head__data:last-of-type{
        border-radius: 0 8px 0 0;
    }

    .table__row__data{
        border-bottom: 1px solid #dfe4e7;
    }

    .table__head__data,
    .table__row__data{
        padding: 17px;
        min-width: 160px;
        width: calc(100% / 6);
    }

</style>

<div class="pdf__header">
    <h1>Jadwal | Session de {{$session->title}}</h1>

    <h2 class="">Professeur&nbsp;: {{$teacher->name}}</h2>
</div>

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
        </tr>
    @endforeach
    </tbody>
</table>

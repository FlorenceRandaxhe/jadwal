@extends('layouts.app-teacher')
@section('title', 'Horaire')
@section('content')

    <section class="section__schedule section">
        <div class="wrapper">
            <form action="/" method="post" class="form">
                <h2 class="title__secondary">Session de septembre 2019</h2>
                <div class="box__container">
                    <div class="schedule__form__head">
                        <label for="name" class="form__label form__label--in-line">Nom du professeur&nbsp;:</label>
                        <input type="text" name="name" id="name" value="Dominique Villain" class="form__input form__input--light">
                    </div>

                    <div class="schedule__form__content">
                        <div class="">
                            <label for="class" class="form__label text--bold form__label--block">Intitulé exact du cours</label>
                            <input value="" type="text" name="class" id="class" placeholder="Ex&nbsp;: Le suicide par la pratique - Théorie" class="form__input form__input--wide">
                        </div>
                        <div class="">
                            <label for="group" class="form__label text--bold form__label--block">Groupes</label>
                            <input value="" type="text" name="group" id="group" placeholder="Ex&nbsp;: 2181-2182" class="form__input form__input--wide">
                        </div>
                        <div class="">
                            <label for="type" class="form__label text--bold form__label--block">Oral/écrit</label>
                            <input value="" type="text" name="type" id="type" placeholder="Ex&nbsp;: Ecrit" class="form__input form__input--wide">
                        </div>
                        <div class="">
                            <label for="local" class="form__label text--bold form__label--block">Locaux possibles</label>
                            <input value="" type="text" name="local" id="local" placeholder="Ex&nbsp;: L21, L23" class="form__input form__input--wide">
                        </div>
                        <div class="">
                            <label for="duration" class="form__label text--bold form__label--block">Durée de l'examen</label>
                            <input value="" type="text" name="duration" id="duration" placeholder="Ex&nbsp;: 2 heures" class="form__input form__input--wide">
                        </div>
                        <div class="">
                            <label for="help" class="form__label text--bold form__label--block">Surveillants souhaités</label>
                            <input value="" type="text" name="help" id="help" placeholder="Ex&nbsp;: Jean Dupont" class="form__input form__input--wide">
                        </div>
                    </div>

                    <div class="">
                        <div class="form__cell form__cell--wide">
                            <label for="more" class="form__label text--bold form__label--block">Demande particulières / indisponibilités / contraintes</label>
                            <textarea name="more" id="more" rows="5" class="form__textarea--wide" placeholder="Ex&nbsp;: Si possible, je préférerais que mes examens aient lieux la 2e et 3e semaines"></textarea>
                        </div>
                    </div>
                </div>
                <div class="btn--right">
                    <button class="btn btn--purple">Envoyer</button>
                </div>
            </form>
        </div>
    </section>


@endsection
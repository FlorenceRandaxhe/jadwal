<?php

namespace App\Http\Controllers;

use App\Jobs\ReminderMailJob;
use App\Jobs\SendMailJob;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MailController extends Controller
{
    /**
     * CHANGER LE CONTENU DU TEXTE DU MAIL DE RAPPEL
     */
    public function sendMail(Session $examSession)
    {
        $examSession->mail_send = true;
        $examSession->save();

        $user = auth()->user();
        $examSession->load('teachers');

        foreach ($examSession->teachers as $teacher) 
        {
            $teacher->pivot->token = Str::random(32);
            $teacher->pivot->save();
            $token = $teacher->pivot->token;
            dispatch(new SendMailJob($examSession, $teacher, $user, $token))->delay(Carbon::now()->addSeconds(5));
        }

        session()->flash('mail_send', 'Le mail pour la session de ' . $examSession->title . ' a bien été envoyé à tous les destinataires ! Il n\'y a plus qu\'a attendre leur réponse');

        return redirect('/sessions/' . $examSession->id);
    }

    public function sendRemiderMail(Session $examSession)
    {
        $user = User::findOrFail($examSession->user_id);
        $sessionTeachers = SessionTeacher::where('session_id', $examSession->id)->where('complete_modals', false)->get();

        foreach ($sessionTeachers as $sessionTeacher) 
        {
            $teacher = Teacher::find($sessionTeacher->teacher_id);
            $token = $sessionTeacher->token;
            dispatch(new ReminderMailJob($examSession, $teacher, $user, $token))->delay(Carbon::now()->addSeconds(5));
        }
        
        session()->flash('remiderMail_send', 'Le mail de rappel pour la session de ' . $examSession->title . ' a bien été envoyé aux destinataires qui n\'ont pas encore rempli leur formulaire !');

        return redirect('/sessions/' . $examSession->id);
    }
}

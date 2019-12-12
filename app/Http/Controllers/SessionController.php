<?php

namespace App\Http\Controllers;

use App\Jobs\ReminderMailJob;
use App\Jobs\SendMailJob;
use App\Mail\SendMail;
use App\Modal;
use App\Session;
use App\Http\Requests\ExamSessionRequest;
use App\SessionTeacher;
use App\Teacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class SessionController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examSessions = Session::with('user')->orderByDesc('limit_date')->paginate(5);
        return view('admin.dashboard', compact('examSessions'));
    }

    /**
     * @param  \App\Session  $examSession
     * @return \Illuminate\Http\Response
     */
    public function show(Session $examSession)
    {
        session(['session' => $examSession]);
        $examSession->load('teachers.modals');
        return view('admin.show', compact('examSession'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if ($request->former)
        {
            $formerSessions = Session::with('user')->orderBy('created_at')->get();
            $oldSession = Session::find($request->former);
            return view('admin.create', ['formerSessions' => $formerSessions, 'oldSession' => $oldSession]);
        }
        $formerSessions = Session::with('user')->orderBy('created_at')->get();
        return view('admin.create', ['formerSessions' => $formerSessions, 'oldSession' => '']);


    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamSessionRequest $request)
    {
        $newSession = new Session();
        $newSession->title = \request('title');
        $newSession->mail = \request('mail');
        $newSession->limit_date =  \request('limit_date');
        $newSession->exam_start =  now();
        $newSession->exam_finish =   now();
        auth()->user()->sessions()->save($newSession);

        if ($request->oldSession)
        {
            $oldSession = Session::find($request->oldSession);
            $oldSession->load('teachers');
            $this->attacheTeachers($oldSession->teachers, $newSession);
            session()->flash('new_session', 'Votre nouvelle session d\'examens a été créée ! Vous pouvez maintenant envoyer le mail aux destinataires');
            return redirect('/sessions/' . $newSession->id);
        }

        $teachers = Teacher::all();
        $this->attacheTeachers($teachers, $newSession);

        session()->flash('new_session', 'Votre nouvelle session d\'examens a été créée ! Vous pouvez maintenant envoyer le mail aux destinataires');
        return redirect('/sessions/' . $newSession->id);
    }

    protected function attacheTeachers($teachers, $newSession)
    {
        foreach ($teachers as $teacher)
        {
            $newSession->teachers()->attach($teacher->id);
        }
    }


    public function edit(Session $examSession)
    {
        return view('admin.edit', compact('examSession'));
    }

    public function update(ExamSessionRequest $request, Session $examSession)
    {
        $examSession->title = \request('title');
        $examSession->mail = \request('mail');
        $examSession->limit_date =  \request('limit_date');
        $examSession->exam_start =  now();
        $examSession->exam_finish =   now();
        $examSession->save();

        return redirect('/sessions/' . $examSession->id);
    }

    /**
     * @param Session $examSession
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Session $examSession)
    {
        $examSession->teachers()->detach();
        $examSession->delete();
        return Back();
    }


    /**
     * @param Session $examSession
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function isComplete(Session $examSession)
    {
        $examSession->is_complete = true;
        $examSession->save();

        // complete session, delete the token so teacher can't access it anymore
        /*$examSession->load('teachers');

        foreach ($examSession->teachers as $teacher)
        {
            $teacher->pivot->token = '';
            $teacher->pivot->save();
        }*/
        return redirect('/sessions/' . $examSession->id);
    }

    public function previewMail(Session $examSession)
    {

        $user = User::findOrFail($examSession->user_id);
        $token = Str::random(32);
        $examSession->load('teachers');

        foreach ($examSession->teachers as $teacher)
        {
            return new SendMail($examSession, $teacher, $user, $token);
        }
    }

    public function sendMail(Session $examSession)
    {
        $examSession->mail_send = true;
        $examSession->save();

        //$session = $request->session()->get('session');

        $user = User::findOrFail($examSession->user_id);

        $examSession->load('teachers');

        foreach ($examSession->teachers as $teacher)
        {
            $teacher->pivot->token = Str::random(32);
            $teacher->pivot->save();
            $token = $teacher->pivot->token;
            dispatch(new SendMailJob($examSession, $teacher, $user, $token))->delay(Carbon::now()->addSeconds(5));
        }

        session()->flash('mail_send', 'Le mail a bien été envoyé à tous les destinataires ! Il n\'y a plus qu\'a attendre leur réponse');
        return redirect('/sessions/' . $examSession->id);
    }

    public function sendRemiderMail(Session $examSession)
    {

        $user = User::findOrFail($examSession->user_id);
        $examSession->load('teachers');

        $teachers = Teacher::all();
        $sessions = SessionTeacher::where('complete_modals', false)->get();
        //return $sessions;
        foreach ($sessions as $session)
        {
            $teacher = Teacher::find($session->teacher_id);
            $token = $session->token;
            //return $sessions;

            dispatch(new ReminderMailJob($examSession, $teacher, $user, $token))->delay(Carbon::now()->addSeconds(5));
        }

        session()->flash('remiderMail_send', 'Le mail a bien été envoyé aux destinataires qui n\'ont pas encore rempli leur formulaire !');
        return redirect('/sessions/' . $examSession->id);
    }
}



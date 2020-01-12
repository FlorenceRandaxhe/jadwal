<?php

namespace App\Http\Controllers;

use App\Session;
use App\Http\Requests\ExamSessionRequest;
use App\Teacher;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        $notifications->markAsRead();
        $sessions = auth()->user()->sessions()->orderByDesc('limit_date')->paginate(4);
        return view('admin.dashboard', ['sessions' => $sessions, 'notifications' => $notifications]);
    }

    public function show(Session $session)
    {
        $this->authorize('update', $session);
        session(['session' => $session]);
        $session->load('teachers.modals');
        return view('admin.show', compact('session'));
    }

    public function previewForm(Session $session)
    {
        $this->authorize('update', $session);
        return view('admin.form', compact('session'));
    }

    public function create(Request $request)
    {
        $formerSessions = auth()->user()->sessions()->orderByDesc('created_at')->get();
        $oldSession = [];
        if ($request->former) {
            $oldSession = Session::find($request->former);
        }
        return view('admin.create', compact('formerSessions', 'oldSession'));
    }

    public function store(ExamSessionRequest $request)
    {
        $session = new Session();
        $session->title = \request('title');
        $session->mail = \request('mail');
        $session->limit_date = \request('limit_date');
        $session->exam_start = \request('exam_start');
        $session->exam_finish = \request('exam_finish');
        auth()->user()->sessions()->save($session);

        //$session->user_id = 1;
        //$session->save();

        if ($request->oldSession) {
            $oldSession = Session::find($request->oldSession);
            $oldSession->load('teachers');
            $this->attachTeachers($oldSession->teachers, $session);
        } else {
            $teachers = Teacher::all();
            $this->attachTeachers($teachers, $session);
        }
        session()->flash('new_session', 'Votre nouvelle session d\'examens a été créée ! Vous pouvez maintenant envoyer le mail aux destinataires');
        return redirect('/sessions/' . $session->id);
    }

    protected function attachTeachers($teachers, $newSession)
    {
        foreach ($teachers as $teacher) {
            $newSession->teachers()->attach($teacher->id);
        }
    }

    public function edit(Session $session)
    {
        return view('admin.edit', compact('session'));
    }

    public function update(ExamSessionRequest $request, Session $session)
    {
        $this->authorize('update', $session);
        $session->title = \request('title');
        $session->mail = \request('mail');
        $session->limit_date = \request('limit_date');
        $session->exam_start = \request('exam_start');
        $session->exam_finish = \request('exam_finish');
        $session->save();

        return redirect('/sessions/' . $session->id);
    }

    public function isComplete(Session $session)
    {
        $this->authorize('update', $session);
        $session->is_complete = true;
        $session->save();

        return redirect('/sessions/' . $session->id);
    }

    public function destroy(Session $session)
    {
        $this->authorize('update', $session);
        $session->teachers()->detach();
        $session->delete();
        return redirect('/sessions');
    }
}



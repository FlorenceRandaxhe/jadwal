<?php

namespace App\Http\Controllers;

use App\Session;
use App\Http\Requests\ExamSessionRequest;
use App\SessionTeacher;
use App\Teacher;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examSessions = Session::where('user_id', auth()->id())
                                ->orderByDesc('limit_date')
                                ->paginate(5);

        return view('admin.dashboard', [
            'examSessions' => $examSessions,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Session  $examSession
     * @return \Illuminate\Http\Response
     */
    public function show(Session $examSession)
    {
        $examSession->load('teachers');
        $modals = $examSession->modals;
        return view('admin.show', ['examSession' => $examSession, 'modals' => $modals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamSessionRequest $request)
    {
        $examSessions = new Session();
        $examSessions->title = \request('title');
        $examSessions->mail = \request('mail');
        $examSessions->limit_date =  \request('limit_date');
        $examSessions->user_id = auth()->id();

        $examSessions->save();

        $teachers = Teacher::all();
        foreach ($teachers as $teacher){
            $sessionTeacher = new SessionTeacher();
            $sessionTeacher->session_id = $examSessions->id;
            $sessionTeacher->teacher_id = $teacher->id;
            $sessionTeacher->save();
        }

        return redirect('/sessions/' . $examSessions->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Session  $examSession
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $examSession)
    {
        //
    }

    /**
     * @param Session $examSession
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function isComplete(Session $examSession)
    {
        $examSession->is_complete = true;
        $examSession->save();
        return redirect('/sessions/' . $examSession->id);
    }

    public function sendMail(Session $examSession, Request $request)
    {
        $examSession->mail_send = true;
        $examSession->save();
        return redirect('/sessions/' . $examSession->id);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Session  $examSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Session $examSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Session  $examSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $examSession)
    {
        //
    }
}

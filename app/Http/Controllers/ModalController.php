<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModalRequest;
use App\Modal;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use Illuminate\Http\Request;
use PDF;

class ModalController extends Controller
{

    public function index($token, Request $request)
    {
        $pivot = SessionTeacher::where('token', $token)->first();
        $modals = Modal::where('teacher_id', $pivot->teacher_id)->where('session_id', $pivot->session_id)->get();
        $oldModals = Modal::all()
            ->where('teacher_id', $pivot->teacher_id)
            ->where('session_id', '!=', $pivot->session_id)
            ->where('save', true);
        $teacher = Teacher::find($pivot->teacher_id);
        $session = Session::find($pivot->session_id);
        $formerModal = [];

        if ($request->formerModal) {
            $formerModal = Modal::find($request->formerModal);
        }
        return view('teacher.form', compact('modals', 'teacher', 'session', 'pivot', 'oldModals', 'formerModal'));
    }

    public function store(ModalRequest $request)
    {
        $newModals = new Modal();
        $newModals->session_id = \request('session_id');
        $newModals->teacher_id = \request('teacher_id');
        $newModals->courses = \request('courses');
        $newModals->groups = \request('groups');
        $newModals->exam_type =  \request('exam_type');
        $newModals->local =  \request('local');
        $newModals->exam_duration =  \request('exam_duration');
        $newModals->supervisor =  \request('supervisor');
        $newModals->requests =  \request('requests');
        $newModals->save = $request->save ? 1 : 0;
        $newModals->save();

        session()->flash('new_modal', 'Le cours a bien été ajouté');
        return back();
    }

    public function unsave(Modal $modal, Request $request)
    {
        $modal->save = false;
        $modal->save();

        session()->flash('duplicate_session', 'Le cours a été enlever des examens sauvgardés');
        return back();
    }

    public function completeModals($token)
    {
        $pivot = SessionTeacher::where('token', $token)->first();
        $pivot->complete_modals = true;
        $pivot->save();
        session()->flash('modal_complete', 'Votre liste d\'examen a bien été envoyée');
        return back();
    }

    public function destroy(Modal $modal)
    {
        $modal->delete();
        return back();
    }

}

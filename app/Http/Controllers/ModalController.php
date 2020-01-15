<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModalRequest;
use App\Modal;
use App\User;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use App\Notifications\ModalComplete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use PDF;

class ModalController extends Controller
{

    public function index($token, Request $request)
    {
        $pivot = SessionTeacher::where('token', $token)->first();
        $modals = Modal::where('teacher_id', $pivot->teacher_id)->where('session_id', $pivot->session_id)->get();
        $oldModals = Modal::all()
            ->where('teacher_id', $pivot->teacher_id)
            ->where('save', 1);
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

        session()->flash('new_modal', 'Le cours ' . $newModals->courses . ' a bien été ajouté');
        return back();
    }

    public function unsave(Modal $oldModal)
    {
        return $oldModal;
        $oldModal->save = 0;
        $oldModal->save();

        session()->flash('duplicate_session', 'Le cours ' . $newModals->courses . ' a été enlevé des examens sauvgardés');
        return back();
    }

    public function completeModals($token)
    {
        $pivot = SessionTeacher::where('token', $token)->first();
        $pivot->complete_modals = true;
        $pivot->save();

        $sess = Session::where('id', $pivot->session_id)->first();
        $user = User::where('id', $sess->user_id)->first();
        $teacher = Teacher::where('id', $pivot->teacher_id)->first();

        Notification::send($user, new ModalComplete($teacher, $sess));

        session()->flash('modal_complete', 'Votre liste d\'examens pour la session de ' . $sess->title . ' a bien été envoyée');
        return back();
    }

    public function destroy(Modal $modal)
    {
        $modal->delete();
        return back();
    }

}

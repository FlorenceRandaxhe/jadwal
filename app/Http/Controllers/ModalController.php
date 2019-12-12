<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModalRequest;
use App\Modal;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($token)
    {
        $pivot = SessionTeacher::where('token', $token)->first();
        $modals = Modal::where('teacher_id', $pivot->teacher_id)->where('session_id', $pivot->session_id)->get();
        $oldSessions = Session::all()->load('oldmodals')->where('id', '!=', $pivot->session_id);
        $teacher = Teacher::find($pivot->teacher_id);
        $session = Session::find($pivot->session_id);
        return view('teacher.form', compact('modals', 'teacher', 'session', 'pivot', 'oldSessions'));
    }

    /**
     * @param ModalRequest $request
     * @return Modal
     *
     */
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
        $newModals->save();
        session()->flash('new_modal', 'Le cours a bien été ajouté');
        return back();
    }

    public function duplicate(Session $session, Request $request)
    {
        $oldModals = Modal::where('session_id', $session->id)
                        ->where('teacher_id', request('teacher_id'))
                        ->get();
        foreach ($oldModals as $oldModal)
        {
            $datas = array(
                'session_id' => request('session_id'),
                'teacher_id' => $oldModal->teacher_id,
                'courses' => $oldModal->courses,
                'groups' => $oldModal->groups,
                'exam_type' =>  $oldModal->exam_type,
                'local'=>  $oldModal->local,
                'exam_duration' =>  $oldModal->exam_duration,
                'supervisor' => $oldModal->supervisor,
                'requests' =>  $oldModal->requests,
            );
            Modal::insert($datas);
        }
        session()->flash('duplicate_session', 'Tous les cours de la session ont été ajouté');
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

    /**
     * @param Modal $modal
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Modal $modal)
    {
        $modal->delete();
        return back();
    }


    public function downloadPDF(Teacher $teacher, Request $request)
    {
        $session = $request->session()->get('session');
        $teacher->load('modals');
        $pdf = PDF::loadView('pdf.modals', ['teacher' => $teacher, 'session' => $session])->setPaper('a4', 'landscape');;
        $fileName =  str_replace(' ', '-', $session->title) . '_' . str_replace(' ', '-', $teacher->name);
        return $pdf->stream($fileName . '' . '.pdf');
    }
}

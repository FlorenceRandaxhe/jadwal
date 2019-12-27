<?php

namespace App\Http\Controllers;

use App\Modal;
use App\Session;
use App\SessionTeacher;
use App\Teacher;
use PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function downloadPDF(Teacher $teacher, Request $request)
    {
        $session = $request->session()->get('session');
        $teacher->load('modals');
        $pdf = PDF::loadView('pdf.admin_modals', ['teacher' => $teacher, 'session' => $session])->setPaper('a4', 'landscape');;
        $fileName =  str_replace(' ', '-', $session->title) . '_' . str_replace(' ', '-', $teacher->name);
        return $pdf->stream($fileName . '' . '.pdf');
    }

    public function downloadTeacherPDF(Teacher $teacher, $token)
    {
        $pivot = SessionTeacher::where('token', $token)->first();
        $modals = Modal::where('teacher_id', $teacher->id)->where('session_id', $pivot->session_id)->get();
        $session = Session::find($pivot->session_id);
        $pdf = PDF::loadView('pdf.teacher_modals', ['teacher' => $teacher, 'session' => $session, 'modals' => $modals])->setPaper('a4', 'landscape');;
        $fileName =  str_replace(' ', '-', $session->title) . '_' . str_replace(' ', '-', $teacher->name);
        return $pdf->stream($fileName . '' . '.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Http\Requests\CsvRequest;
use App\Teacher;
use App\SessionTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = auth()->user()->teachers()->paginate(10);
        return view('admin.teachers', compact('teachers'));
    }

    public function store(TeacherRequest $request)
    {
        $teacher = new Teacher();
        $teacher->name = \request('name');
        $teacher->email = \request('email');
        auth()->user()->teachers()->save($teacher);

        session()->flash('new_teacher', $teacher->name . ' a été ajouté à votre liste de professeurs');
        return back();
    }

    public function storecsv(CsvRequest $request)
    {
        $handle = fopen(request('file'), "r");
        $row = 1;
        $arr = [];

        while (($datas = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $arr[] = $datas;
            $name = $datas[0];
            $email = $datas[1];

            foreach ($datas as $data) {
               $newTeacher = Teacher::where('email', $email)->first();
        
                if (!$newTeacher) {
                    $newTeacher = new Teacher();
                    $newTeacher->name = $name;
                    $newTeacher->email = $email;
                    auth()->user()->teachers()->save($newTeacher);

                    session()->flash('new_csv', 'Tous les professeurs ont bien été importé !');
                }
            }
        }
        fclose($handle);
        return back();
    }

    public function attach(TeacherRequest $request)
    {
        $teacher = Teacher::where('email', \request('email'))->first();
        $session = $request->session()->get('session');

        if ($teacher) {
            $newRel = Teacher::find($teacher->id);
            $newRel->sessions()->attach($session);
            return back();
        }

        $newTeacher = new Teacher();
        $newTeacher->name = \request('name');
        $newTeacher->email = \request('email');
        auth()->user()->teachers()->save($newTeacher);

        $newTeacher->sessions()->attach($session);
        return back();
    }

    public function detach(Request $request, Teacher $teacher)
    {
        $this->authorize('update', $teacher);
        $session = $request->session()->get('session');
        Teacher::find($teacher->id)->sessions()->detach($session);
        return back();
    }

    public function show(Teacher $teacher, Request $request)
    {
        $this->authorize('update', $teacher);
        $session = $request->session()->get('session');
        $teacher->load('modals');
        return view('admin.modals', compact('teacher', 'session'));
    }

    public function destroy(Teacher $teacher)
    {
        $this->authorize('update', $teacher);
        $modalsAwaiting = SessionTeacher::where('complete_modals', 0)->where('teacher_id', $teacher->id)->first();

        if ($modalsAwaiting) 
        {
            session()->flash('modal_awaiting', $teacher->name . ' ne peut pas être supprimé car il n\'a pas encore renvoyé toutes ses modalités d\'examen');
            return back();
        }
        $teacher->sessions()->detach();
        $teacher->delete();
        return back();
    }

}

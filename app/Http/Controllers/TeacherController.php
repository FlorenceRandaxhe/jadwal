<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Teacher;
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

        session()->flash('new_teacher', 'Un nouveau professeur a été créé !');
        return back();
    }

    public function storecsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        // Store the blog post...
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
        $teacher->sessions()->detach();
        $teacher->delete();
        return back();
    }

}

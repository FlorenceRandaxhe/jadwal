<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(10);
        return view('admin.teachers', compact('teachers'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param TeacherRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        if ($teacher)
        {
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
        $session = $request->session()->get('session');
        Teacher::find($teacher->id)->sessions()->detach($session);
        return back();
    }

    /**
     * @param Teacher $teacher
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Teacher $teacher, Request $request)
    {
        $session = $request->session()->get('session');
        $teacher->load('modals');
        return view('admin.modals', compact('teacher', 'session'));
    }

    /**
     * @param Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->sessions()->detach();
        $teacher->delete();
        return back();
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::where('user_id', auth()->id())->get();;

        return view('admin.teachers', [
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage
     *
     * @param TeacherRequest $request
     * @param Teacher $teacher
     * @return Teacher
     */
    public function store(TeacherRequest $request, Teacher $teacher)
    {
        $teacher = new Teacher();
        $teacher->name = \request('name');
        $teacher->email = \request('email');
        $teacher->user_id = auth()->id();
        $teacher->save();

        return back();
    }

    public function storecsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        // Store the blog post...
    }


    public function attach(Teacher $teacher, TeacherRequest $request)
    {
        $teacher = Teacher::where('email', \request('email'))->first();

        if ($teacher){
            $newRel = Teacher::find($teacher->id);
            $newRel->sessions()->attach($request->sessionId, ['created_at' => NOW(), 'updated_at' => NOW()]);
            return back();
        }

        $newTeacher = new Teacher();
        $newTeacher->name = \request('name');
        $newTeacher->email = \request('email');
        $newTeacher->user_id = auth()->id();
        $newTeacher->save();

        $newRel = Teacher::find($newTeacher->id);

        $newRel->sessions()->attach($request->sessionId, ['created_at' => NOW(), 'updated_at' => NOW()]);
        return back();
    }


    public function detach(Teacher $teacher, Request $request)
    {
        $deleteRel = Teacher::find($request->teacherId);
        $deleteRel->sessions()->detach($request->sessionId);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * @param Teacher $teacher
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return back();
    }

}

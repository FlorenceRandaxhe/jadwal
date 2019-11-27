<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModalRequest;
use App\Modal;
use App\Session;
use App\Teacher;
use Illuminate\Http\Request;
use PDF;

class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * @param ModalRequest $request
     * @return Modal
     *
     */
    public function store(ModalRequest $request)
    {
        $newModals = new Modal();

        $newModals->courses = \request('courses');
        $newModals->groups = \request('groups');
        $newModals->exam_type =  \request('exam_type');
        $newModals->local =  \request('local');
        $newModals->exam_duration =  \request('exam_duration');
        $newModals->supervisor =  \request('supervisor');
        $newModals->requests =  \request('requests');

        $newModals->save();

        return redirect('/modals');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function show(Modal $modal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function edit(Modal $modal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modal $modal)
    {
        //
    }

    /**
     * @param Modal $modal
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Modal $modal)
    {

    }

}

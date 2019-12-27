<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Modal extends Model
{

    protected $fillable = [
        'session_id', 'teacher_id', 'courses', 'groups', 'exam_type', 'local', 'exam_duration', 'supervisor', 'requests'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function session()
    {
        return $this->belongsTo('App\Session');
    }


}

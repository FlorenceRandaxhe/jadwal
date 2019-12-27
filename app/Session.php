<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['title', 'mail', 'limit_date'];

    protected $dates = ['created_at', 'updated_at', 'limit_date', 'exam_start', 'exam_finish'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'session_teachers', 'session_id', 'teacher_id')
            ->withPivot('complete_modals')
            ->where('user_id', auth()->id());
    }

    public function completeModals()
    {
        return $this->hasMany(SessionTeacher::class, 'session_id')->where('complete_modals', true);
    }

    public function oldmodals()
    {
        return $this->hasMany(Modal::class);
    }

}



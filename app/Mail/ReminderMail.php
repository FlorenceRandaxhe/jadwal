<?php

namespace App\Mail;

use App\Session;
use App\Teacher;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $session;
    protected $teacher;
    protected $user;
    protected $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Session $session, Teacher $teacher, User $user, $token)
    {
        $this->session = $session;
        $this->teacher = $teacher;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAPPEL : Jadwal - Modalités d\'examen - ' . $this->session->title)
            ->from($this->user->email)
            ->markdown('emails.sendReminderMail',  ['session' => $this->session, 'teacher' => $this->teacher, 'token' => $this->token, 'user' => $this->user]);
    }

}

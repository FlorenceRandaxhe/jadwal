<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModalComplete extends Notification
{
    use Queueable;
    protected $teacher;
    protected $sessions;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($teacher, $session)
    {
        $this->teacher = $teacher->name;
        $this->session = $session->title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle modalité d\'examens')
                    ->greeting('Bonjour,')
                    ->line('Un professeur a envoyé ses modalités d\'examens.')
                    ->action('Me connecter', url('/login'))
                    ->salutation('Bonne journée');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'teacher' => $this->teacher,
            'session' => $this->session
        ];
    }
}

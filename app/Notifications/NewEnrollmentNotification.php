<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Enrollment;

class NewEnrollmentNotification extends Notification
{
    use Queueable;

    protected $enrollment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // only database for now
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'enrollment_id' => $this->enrollment->id,
            'user_name' => $this->enrollment->user->name,
            'course_title' => $this->enrollment->course->title,
            'message' => "Pengguna {$this->enrollment->user->name} meminta persetujuan untuk kelas {$this->enrollment->course->title}.",
            'link' => route('settings.users')
        ];
    }
}

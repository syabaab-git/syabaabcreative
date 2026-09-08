<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Lesson;

class LessonPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $lesson;

    /**
     * Create a new notification instance.
     */
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Materi Baru: ' . $this->lesson->title,
            'message' => 'Materi baru telah dirilis di kelas ' . $this->lesson->course->title . '. Ayo pelajari sekarang!',
            'url' => route('member.learning.show', ['course' => $this->lesson->course->slug, 'lesson_id' => $this->lesson->id])
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SystemNotification;

class StudentSubmissionStatusChanged extends Notification
{
    use Queueable;

    protected $submission;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($submission, $status)
    {
        $this->submission = $submission;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Submission Status Changed'))
            ->greeting(__('Hello :name!', ['name' => $notifiable->name]))
            ->line(__('The status of your submission ":title" has been changed to :status.', [
                'title' => $this->submission->title,
                'status' => __($this->status)
            ]))
            ->action(__('View Submission'), url(route('student.submissions.show', $this->submission)))
            ->line(__('Thank you for participating in our competitions!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'submission_title' => $this->submission->title,
            'status' => $this->status,
        ];
    }

    /**
     * Custom method to store notification in our custom table
     */
    public function toDatabase($notifiable)
    {
        return SystemNotification::create([
            'user_id' => $notifiable->id,
            'title_ar' => 'تغير حالة المشاركة',
            'title_en' => 'Submission Status Changed',
            'message_ar' => "تغيرت حالة مشاركتك \"{$this->submission->title_ar}\" إلى {$this->status}",
            'message_en' => "The status of your submission \"{$this->submission->title_en}\" has been changed to {$this->status}",
            'type' => 'info',
            'data' => $this->toArray($notifiable),
            'is_read' => false,
        ]);
    }
}
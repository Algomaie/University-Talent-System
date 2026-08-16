<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Submission;
use App\Models\SystemNotification;

class SubmissionStatusChanged extends Notification
{
    use Queueable;

    protected $submission;
    protected $previousStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Submission $submission, $previousStatus)
    {
        $this->submission = $submission;
        $this->previousStatus = $previousStatus;
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
            ->subject(__('Submission Status Updated'))
            ->greeting(__('Hello :name!', ['name' => $notifiable->name]))
            ->line(__('The status of your submission ":title" has been updated.', ['title' => $this->submission->title]))
            ->line(__('Previous status: :status', ['status' => ucfirst($this->previousStatus)]))
            ->line(__('New status: :status', ['status' => ucfirst($this->submission->status)]))
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
            'title' => $this->submission->title,
            'previous_status' => $this->previousStatus,
            'new_status' => $this->submission->status,
            'competition_title' => $this->submission->competition->title,
        ];
    }

    /**
     * Custom method to store notification in our custom table
     */
    public function toDatabase($notifiable)
    {
        return SystemNotification::create([
            'user_id' => $notifiable->id,
            'title_ar' => 'تحديث حالة المشاركة',
            'title_en' => 'Submission Status Updated',
            'message_ar' => "تم تحديث حالة مشاركتك \"{$this->submission->title_ar}\" من {$this->previousStatus} إلى {$this->submission->status}",
            'message_en' => "The status of your submission \"{$this->submission->title_en}\" has been updated from {$this->previousStatus} to {$this->submission->status}",
            'type' => 'info',
            'data' => $this->toArray($notifiable),
            'is_read' => false,
        ]);
    }
}
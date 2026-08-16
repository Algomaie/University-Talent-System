<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\SystemNotification;

class SubmissionEvaluated extends Notification
{
    use Queueable;

    protected $submission;
    protected $evaluation;

    /**
     * Create a new notification instance.
     */
    public function __construct($submission, $evaluation)
    {
        $this->submission = $submission;
        $this->evaluation = $evaluation;
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
            ->subject(__('New Submission Evaluated'))
            ->greeting(__('Hello :name!', ['name' => $notifiable->name]))
            ->line(__('A submission has been evaluated by :evaluator.', [
                'evaluator' => $this->evaluation->evaluator->name
            ]))
            ->line(__('Submission: :title', ['title' => $this->submission->title]))
            ->line(__('Overall Score: :score/100', ['score' => $this->evaluation->overall_score]))
            ->action(__('View Evaluation'), url(route('manager.evaluations.show', $this->submission)))
            ->line(__('Thank you for managing our competitions!'));
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
            'evaluator_name' => $this->evaluation->evaluator->name,
            'overall_score' => $this->evaluation->overall_score,
        ];
    }

    /**
     * Custom method to store notification in our custom table
     */
    public function toDatabase($notifiable)
    {
        return SystemNotification::create([
            'user_id' => $notifiable->id,
            'title_ar' => 'تم تقييم مشاركة جديدة',
            'title_en' => 'New Submission Evaluated',
            'message_ar' => "تم تقييم مشاركة جديدة: {$this->submission->title_ar}",
            'message_en' => "A new submission has been evaluated: {$this->submission->title_en}",
            'type' => 'info',
            'data' => $this->toArray($notifiable),
            'is_read' => false,
        ]);
    }
}
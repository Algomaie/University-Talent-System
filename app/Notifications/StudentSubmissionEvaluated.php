<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Evaluation;
use App\Models\SystemNotification;

class StudentSubmissionEvaluated extends Notification
{
    use Queueable;

    protected $evaluation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Evaluation $evaluation)
    {
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
            ->subject(__('Your Submission Has Been Evaluated'))
            ->greeting(__('Hello :name!', ['name' => $notifiable->name]))
            ->line(__('Your submission ":title" for the competition ":competition" has been evaluated.', [
                'title' => $this->evaluation->submission->title,
                'competition' => $this->evaluation->submission->competition->title
            ]))
            ->line(__('Overall Score: :score/100', ['score' => $this->evaluation->overall_score]))
            ->line(__('Grade: :grade', ['grade' => $this->evaluation->getScoreGrade()]))
            ->action(__('View Evaluation'), url(route('student.submissions.show', $this->evaluation->submission)))
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
            'evaluation_id' => $this->evaluation->id,
            'submission_title' => $this->evaluation->submission->title,
            'competition_title' => $this->evaluation->submission->competition->title,
            'overall_score' => $this->evaluation->overall_score,
            'grade' => $this->evaluation->getScoreGrade(),
        ];
    }

    /**
     * Custom method to store notification in our custom table
     */
    public function toDatabase($notifiable)
    {
        return SystemNotification::create([
            'user_id' => $notifiable->id,
            'title_ar' => 'تم تقييم مشاركتك',
            'title_en' => 'Your Submission Has Been Evaluated',
            'message_ar' => "تم تقييم مشاركتك في المسابقة: {$this->evaluation->submission->competition->title_ar}",
            'message_en' => "Your submission has been evaluated for competition: {$this->evaluation->submission->competition->title_en}",
            'type' => 'info',
            'data' => $this->toArray($notifiable),
            'is_read' => false,
        ]);
    }
}
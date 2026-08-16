<?php

namespace App\Services;

use App\Models\SystemNotification;
use App\Models\User;

class NotificationService
{
    public function sendNotification(User $user, string $titleAr, string $titleEn, string $messageAr, string $messageEn, string $type = 'info', array $data = [])
    {
        return SystemNotification::create([
            'user_id' => $user->id,
            'title_ar' => $titleAr,
            'title_en' => $titleEn,
            'message_ar' => $messageAr,
            'message_en' => $messageEn,
            'type' => $type,
            'data' => $data,
            'is_read' => false,
        ]);
    }

    public function sendBulkNotification(array $userIds, string $titleAr, string $titleEn, string $messageAr, string $messageEn, string $type = 'info', array $data = [])
    {
        $notifications = [];
        
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'title_ar' => $titleAr,
                'title_en' => $titleEn,
                'message_ar' => $messageAr,
                'message_en' => $messageEn,
                'type' => $type,
                'data' => $data,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        return SystemNotification::insert($notifications);
    }

    public function sendSubmissionNotification($submission)
    {
        $titleAr = 'إشعار جديد - تقديم مشاركة';
        $titleEn = 'New Submission Notification';
        $messageAr = "تم تقديم مشاركة جديدة في المسابقة: {$submission->competition->title_ar}";
        $messageEn = "A new submission has been submitted for competition: {$submission->competition->title_en}";
        
        // Send to managers and admins
        $managers = User::whereIn('role', ['manager', 'admin'])->pluck('id')->toArray();
        
        return $this->sendBulkNotification($managers, $titleAr, $titleEn, $messageAr, $messageEn, 'info', [
            'submission_id' => $submission->id,
            'competition_id' => $submission->competition_id,
        ]);
    }

    public function sendEvaluationNotification($evaluation)
    {
        $titleAr = 'تم تقييم مشاركتك';
        $titleEn = 'Your Submission Has Been Evaluated';
        $messageAr = "تم تقييم مشاركتك في المسابقة: {$evaluation->submission->competition->title_ar}";
        $messageEn = "Your submission has been evaluated for competition: {$evaluation->submission->competition->title_en}";
        
        return $this->sendNotification(
            $evaluation->submission->user,
            $titleAr,
            $titleEn,
            $messageAr,
            $messageEn,
            'info',
            [
                'evaluation_id' => $evaluation->id,
                'submission_id' => $evaluation->submission_id,
                'score' => $evaluation->overall_score,
            ]
        );
    }

    public function sendCompetitionNotification($competition, $messageAr, $messageEn)
    {
        $titleAr = 'إشعار مسابقة';
        $titleEn = 'Competition Notification';
        
        // Send to all students
        $students = User::where('role', 'student')->pluck('id')->toArray();
        
        return $this->sendBulkNotification($students, $titleAr, $titleEn, $messageAr, $messageEn, 'info', [
            'competition_id' => $competition->id,
        ]);
    }

    public function getUnreadCount(User $user)
    {
        return $user->notifications()->unread()->count();
    }

    public function markAsRead(SystemNotification $notification)
    {
        return $notification->markAsRead();
    }

    public function markAllAsRead(User $user)
    {
        return $user->notifications()->unread()->update(['is_read' => true]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\SystemNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InternalApiController extends Controller
{
    /**
     * Get allowed talents for a competition.
     */
    public function competitionTalents(Competition $competition): JsonResponse
    {
        $talents = $competition->allowedTalentsList();

        return response()->json($talents);
    }

    /**
     * Get unread notification count for the authenticated user.
     */
    public function unreadNotificationCount(Request $request): JsonResponse
    {
        $count = $request->user()->notifications()->unread()->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Mark a notification as read.
     */
    public function markNotificationRead(Request $request, int $notificationId): JsonResponse
    {
        $notification = $request->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * List recent notifications for the authenticated user.
     */
    public function listNotifications(Request $request): JsonResponse
    {
        $notifications = $request->user()->notifications()
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'type_icon' => $notification->type_icon,
                    'is_read' => $notification->is_read,
                    'time_ago' => $notification->created_at->diffForHumans(),
                    'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json(['notifications' => $notifications]);
    }
}

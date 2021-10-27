<?php

namespace App\Http\Controllers;

use App\Services\Contracts\NotificationServiceContract;

class NotificationController extends Controller
{
    private NotificationServiceContract $notificationService;

    /**
     * @param NotificationServiceContract $notificationService
     */
    public function __construct (NotificationServiceContract $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getStudentNotification ($id_account, $id_notification_offset = '0')
    {
        return $this->notificationService->getNotificationByReceiver($id_account, true,
                                                                     $id_notification_offset);
    }

    public function getTeacherNotification ($id_account, $id_notification_offset = '0')
    {
        return $this->notificationService->getNotificationByReceiver($id_account, false,
                                                                     $id_notification_offset);
    }
}

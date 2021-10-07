<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Services\Contracts\NotificationServiceContract;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private NotificationServiceContract $notificationService;

    /**
     * NotificationController constructor.
     * @param NotificationServiceContract $notificationService
     */
    public function __construct (NotificationServiceContract $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getStudentNotification ($id_account, $id_notification = '')
    {
        return $this->notificationService->getNotificationByReceiver($id_account, true, $id_notification);
    }

    public function getTeacherNotification ($id_account, $id_notification = '')
    {
        return $this->notificationService->getNotificationByReceiver($id_account, false, $id_notification);
    }

    public function setDelete (Request $request)
    {
        $this->notificationService->setDelete($request->all());
    }

}

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

    public function getNotifications ($id_student, $id_account, $id_notification = '')
    {
        return $this->notificationService->getNotificationsApp($id_student, $id_account, $id_notification);
    }

    public function setDelete (Request $request)
    {
        $this->notificationService->setDelete($request->all());
    }

}

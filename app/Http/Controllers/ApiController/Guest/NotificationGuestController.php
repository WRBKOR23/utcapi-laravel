<?php


namespace App\Http\Controllers\ApiController\Guest;


use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\NotificationGuestServiceContract;

class NotificationGuestController extends Controller
{
    private NotificationGuestServiceContract $notificationGuestService;

    /**
     * NotificationGuestController constructor.
     * @param NotificationGuestServiceContract $notificationGuestService
     */
    public function __construct (NotificationGuestServiceContract $notificationGuestService)
    {
        $this->notificationGuestService = $notificationGuestService;
    }

    public function getNotifications ($id_guest, $id_notification = '0')
    {
        return $this->notificationGuestService->getNotifications($id_guest, $id_notification);
    }
}

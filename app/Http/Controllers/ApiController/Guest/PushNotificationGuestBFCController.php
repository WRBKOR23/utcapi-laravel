<?php

namespace App\Http\Controllers\ApiController\Guest;

use App\Exceptions\InvalidFormRequestException;
use App\Http\Controllers\Controller;
use App\Http\RequestForm\PushNotificationGuestForm;
use App\Services\Contracts\Guest\NotificationGuestServiceContract;
use App\Services\Contracts\NotifyServiceContract;
use Illuminate\Http\Request;

class PushNotificationGuestBFCController extends Controller
{
    private PushNotificationGuestForm $pushNotificationGuestForm;

    private NotificationGuestServiceContract $notificationGuestService;
    private NotifyServiceContract $notifyService;

    /**
     * PushNotificationGuestBFCController constructor.
     * @param PushNotificationGuestForm $pushNotificationForm
     * @param NotificationGuestServiceContract $notificationGuestService
     * @param NotifyServiceContract $notifyService
     */
    public function __construct (PushNotificationGuestForm $pushNotificationForm,
                                 NotificationGuestServiceContract $notificationGuestService,
                                 NotifyServiceContract $notifyService)
    {
        $this->pushNotificationGuestForm = $pushNotificationForm;
        $this->notificationGuestService  = $notificationGuestService;
        $this->notifyService             = $notifyService;
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function pushNotification (Request $request)
    {
        $this->pushNotificationGuestForm->validate($request);

        $id_guest_list = $this->notificationGuestService->pushNotificationGuestBFC($request->id_notification, $request->faculty, $request->academic_year);

        $this->notifyService->sendNotification($request->info, $id_guest_list);

        return response('OK');
    }
}

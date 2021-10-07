<?php

namespace App\Http\Controllers\WebController;

use App\Exceptions\InvalidFormRequestException;
use App\Http\Controllers\Controller;
use App\Http\FormRequest\PushNotificationForm;
use App\Services\Contracts\NotificationServiceContract;
use App\Services\Contracts\NotifyServiceContract;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private PushNotificationForm $form;
    private NotificationServiceContract $notificationService;
    private NotifyServiceContract $notifyService;

    /**
     * PushNotificationBMCController constructor.
     * @param PushNotificationForm $pushNotificationForm
     * @param NotificationServiceContract $notificationService
     * @param NotifyServiceContract $notifyService
     */
    public function __construct (PushNotificationForm        $pushNotificationForm,
                                 NotificationServiceContract $notificationService,
                                 NotifyServiceContract       $notifyService)
    {
        $this->form                = $pushNotificationForm;
        $this->notificationService = $notificationService;
        $this->notifyService       = $notifyService;
    }

    public function getNotifications ($id_sender, $num)
    {
        return $this->notificationService->getNotificationBySender($id_sender, $num);
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function pushNotificationBFC (Request $request)
    {
        $this->form->validate($request);

        $id_account_list = $this->notificationService->pushNotificationBFC($request->info, $request->class_list);
        $this->notifyService->sendNotification($request->info, $id_account_list);

        return response('');
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function pushNotificationBMC (Request $request)
    {
        $this->form->validate($request);

        $id_account_list = $this->notificationService->pushNotificationBMC($request->info, $request->class_list);
        $this->notifyService->sendNotification($request->info, $id_account_list);

        return response('');
    }

    public function deleteNotification (Request $request)
    {
        $this->notificationService->setDelete($request->all());
    }
}

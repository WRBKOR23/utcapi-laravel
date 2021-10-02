<?php


namespace App\Services\Guest;


use App\Repositories\Contracts\GuestInfoDepositoryContract;
use App\Repositories\Contracts\NotificationGuestDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\Guest\NotificationGuestServiceContract;

class NotificationGuestService implements NotificationGuestServiceContract
{
    private NotificationGuestDepositoryContract $notificationGuestDepository;
    private GuestInfoDepositoryContract $guestInfoDepository;

    /**
     * NotificationGuestService constructor.
     * @param NotificationGuestDepositoryContract $notificationGuestDepository
     * @param GuestInfoDepositoryContract $guestInfoDepository
     */
    public function __construct (NotificationGuestDepositoryContract $notificationGuestDepository, GuestInfoDepositoryContract $guestInfoDepository)
    {
        $this->notificationGuestDepository = $notificationGuestDepository;
        $this->guestInfoDepository         = $guestInfoDepository;
    }

    public function pushNotificationGuestBFC ($id_notification, $id_faculty_list, $academic_year_list)
    {
        $id_guest_list = $this->guestInfoDepository->getIDGuests($id_faculty_list, $academic_year_list);
        $this->_insertMultiple($id_notification, $id_guest_list);
        $this->_updateNotificationVersion($id_guest_list);

        return $id_guest_list;
    }

    private function _insertMultiple ($id_notification, $id_guest_list)
    {
        $data = SharedFunctions::setUpNotificationGuestData($id_notification, $id_guest_list);
        $this->notificationGuestDepository->insertMultiple($data);
    }

    private function _updateNotificationVersion ($id_guest_list)
    {
        $this->guestInfoDepository->updateDataVersionMultiple($id_guest_list, 'Notification_Data_Version');
    }

    public function getNotifications ($id_guest, $id_notification): array
    {
        $id_notification_list = $this->notificationGuestDepository->getIDNotifications($id_guest, $id_notification);
        $data                 = $this->notificationGuestDepository->getNotifications($id_notification_list);

        return empty($data) ? $data : SharedFunctions::formatGetNotificationResponse($data);

    }
}

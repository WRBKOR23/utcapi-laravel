<?php


namespace App\Services\Guest;


use App\BusinessClass\FirebaseCloudMessaging;
use App\Depositories\Contracts\GuestInfoDepositoryContract;
use App\Services\Contracts\Guest\NotifyGuestServiceContract;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;

class NotifyGuestService implements NotifyGuestServiceContract
{
    private GuestInfoDepositoryContract $guestInfoDepository;
    private FirebaseCloudMessaging $fcm;

    /**
     * NotifyGuestService constructor.
     * @param GuestInfoDepositoryContract $guestInfoDepository
     * @param FirebaseCloudMessaging $fcm
     */
    public function __construct (GuestInfoDepositoryContract $guestInfoDepository, FirebaseCloudMessaging $fcm)
    {
        $this->guestInfoDepository = $guestInfoDepository;
        $this->fcm                 = $fcm;
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendNotification ($noti, $id_guest_list)
    {
        $device_token_list = $this->_getDeviceTokens($id_guest_list);
        $this->_send($noti, $device_token_list);
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    private function _send ($noti, $device_token_list)
    {
        $this->fcm->setUpData($noti, $device_token_list);
        $this->fcm->send();
    }

    private function _getDeviceTokens ($id_guest_list)
    {
        return $this->guestInfoDepository->getDeviceTokens($id_guest_list);
    }
}

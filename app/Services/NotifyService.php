<?php


namespace App\Services;


use App\BusinessClass\FirebaseCloudMessaging;
use App\Depositories\Contracts\DeviceDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\NotifyServiceContract;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;

class NotifyService implements NotifyServiceContract
{
    private DeviceDepositoryContract $deviceDepository;
    private FirebaseCloudMessaging $fcm;

    /**
     * NotifyService constructor.
     * @param DeviceDepositoryContract $depositoryContract
     * @param FirebaseCloudMessaging $fcm
     */
    public function __construct (DeviceDepositoryContract $depositoryContract, FirebaseCloudMessaging $fcm)
    {
        $this->deviceDepository = $depositoryContract;
        $this->fcm              = $fcm;
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendNotification ($notification, $id_account_list)
    {
        $device_token_list = $this->_getDeviceTokens($id_account_list);
        $invalid_dt_list   = $this->_send($notification, $device_token_list);
        $this->_deleteInvalidTokens($invalid_dt_list);
    }

    private function _getDeviceTokens ($id_account_list) : array
    {
        if (empty($id_account_list))
        {
            return [];
        }

        return $this->deviceDepository->getTokens(SharedFunctions::formatArray($id_account_list, 'id_account'));
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    private function _send ($notification, $device_token_list): array
    {
        $this->fcm->setUpData($notification, $device_token_list);
        return $this->fcm->send();
    }

    private function _deleteInvalidTokens ($device_token_list)
    {
        if (empty($device_token_list))
        {
            return;
        }

        $this->deviceDepository->deleteMultiple($device_token_list);
    }
}

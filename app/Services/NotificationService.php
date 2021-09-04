<?php


namespace App\Services;


use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Depositories\Contracts\NotificationAccountDepositoryContract;
use App\Depositories\Contracts\NotificationDepositoryContract;
use App\Depositories\Contracts\ParticipateDepositoryContract;
use App\Depositories\Contracts\StudentDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\NotificationServiceContract;

class NotificationService implements NotificationServiceContract
{
    private NotificationAccountDepositoryContract $notificationAccountDepository;
    private DataVersionStudentDepositoryContract $dataVersionStudentDepository;
    private NotificationDepositoryContract $notificationDepository;
    private ParticipateDepositoryContract $participateDepository;
    private AccountDepositoryContract $accountDepository;
    private StudentDepositoryContract $studentDepository;

    /**
     * NotificationService constructor.
     * @param NotificationAccountDepositoryContract $notificationAccountDepository
     * @param DataVersionStudentDepositoryContract $dataVersionStudentDepository
     * @param NotificationDepositoryContract $notificationDepository
     * @param ParticipateDepositoryContract $participateDepository
     * @param AccountDepositoryContract $accountDepository
     * @param StudentDepositoryContract $studentDepository
     */
    public function __construct (NotificationAccountDepositoryContract $notificationAccountDepository,
                                 DataVersionStudentDepositoryContract $dataVersionStudentDepository,
                                 NotificationDepositoryContract $notificationDepository,
                                 ParticipateDepositoryContract $participateDepository,
                                 AccountDepositoryContract $accountDepository,
                                 StudentDepositoryContract $studentDepository)
    {
        $this->notificationAccountDepository = $notificationAccountDepository;
        $this->dataVersionStudentDepository  = $dataVersionStudentDepository;
        $this->notificationDepository        = $notificationDepository;
        $this->participateDepository         = $participateDepository;
        $this->accountDepository             = $accountDepository;
        $this->studentDepository             = $studentDepository;
    }

    public function pushNotificationBFC ($noti, $class_list): array
    {
        $id_student_list = $this->_getIDStudentsBFC($class_list);
        $id_account_list = $this->_sharedFunctions($noti, $id_student_list);

        return $id_account_list;
    }

    private function _getIDStudentsBFC ($class_list)
    {
        return $this->studentDepository->getIDStudentsBFC($class_list);
    }

    public function pushNotificationBMC ($noti, $class_list): array
    {
        $id_student_list = $this->_getIDStudentsBMC($class_list);
        $id_account_list = $this->_sharedFunctions($noti, $id_student_list);

        return $id_account_list;
    }

    private function _getIDStudentsBMC ($class_list)
    {
        return $this->participateDepository->getIDStudentsBMC($class_list);
    }

    private function _sharedFunctions ($noti, $id_student_list): array
    {
        $id_account_list = $this->_getIDAccounts($id_student_list);
        $id_notification = $this->_insertNotification($noti);
        $this->_insertNotificationAccount($id_account_list, $id_notification);
        $this->_updateNotificationVersion($id_notification);

        return $id_account_list;
    }

    private function _getIDAccounts ($id_student_list)
    {
        return $this->accountDepository->getIDAccounts($id_student_list);
    }

    private function _insertNotification ($noti)
    {
        return $this->notificationDepository->insertGetID($noti);
    }

    private function _insertNotificationAccount ($id_account_list, $id_notification)
    {
        $this->notificationAccountDepository->insertMultiple($id_account_list, $id_notification);
    }


    public function getNotificationsApp ($id_account, $id_notification = '0'): array
    {
        $data = $this->notificationAccountDepository->getNotifications($id_account, $id_notification);
        return SharedFunctions::formatGetNotificationResponse($data);
    }


    public function setDelete ($id_notification_list)
    {
        $this->notificationDepository->setDelete($id_notification_list);
        foreach ($id_notification_list as $id_notification)
        {
            $this->_updateNotificationVersion($id_notification);
        }
    }

    private function _updateNotificationVersion ($id_notification)
    {
        $this->dataVersionStudentDepository->updateMultiple($id_notification);
    }


    public function getNotificationsWeb ($id_sender, $num)
    {
        return $this->notificationDepository->getNotifications($id_sender, $num);
    }
}

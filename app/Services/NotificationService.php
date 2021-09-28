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
                                 DataVersionStudentDepositoryContract  $dataVersionStudentDepository,
                                 NotificationDepositoryContract        $notificationDepository,
                                 ParticipateDepositoryContract         $participateDepository,
                                 AccountDepositoryContract             $accountDepository,
                                 StudentDepositoryContract             $studentDepository)
    {
        $this->notificationAccountDepository = $notificationAccountDepository;
        $this->dataVersionStudentDepository  = $dataVersionStudentDepository;
        $this->notificationDepository        = $notificationDepository;
        $this->participateDepository         = $participateDepository;
        $this->accountDepository             = $accountDepository;
        $this->studentDepository             = $studentDepository;
    }

    public function pushNotificationBFC ($notification, $class_list) : array
    {
        $id_student_list = $this->_getIDStudentsBFC($class_list);
        $id_account_list = $this->_sharedFunctions($notification, $id_student_list);

        return $id_account_list;
    }

    private function _getIDStudentsBFC ($class_list)
    {
        return $this->studentDepository->getIDStudentsBFC($class_list);
    }

    public function pushNotificationBMC ($notification, $class_list) : array
    {
        $id_student_list = $this->_getIDStudentsBMC($class_list);
        $id_account_list = $this->_sharedFunctions($notification, $id_student_list);

        return $id_account_list;
    }

    private function _getIDStudentsBMC ($class_list)
    {
        return $this->participateDepository->getIDStudentsBMC($class_list);
    }

    private function _sharedFunctions ($notification, $id_student_list) : array
    {
        $id_account_list = $this->_getIDAccounts(SharedFunctions::formatArray($id_student_list, 'id_student'));
        $id_notification = $this->_insertNotification($notification);
        $this->_insertNotificationAccount($id_account_list, $id_notification);
        $this->_updateNotificationVersion($id_student_list);

        return $id_account_list;
    }

    private function _getIDAccounts ($id_student_list) : array
    {
        if (empty($id_student_list))
        {
            return [];
        }

        return $this->accountDepository->getIDAccounts($id_student_list);
    }

    private function _insertNotification ($notification)
    {
        $notification = SharedFunctions::setUpNotificationData($notification);
        return $this->notificationDepository->insertGetID($notification);
    }

    private function _insertNotificationAccount ($id_account_list, $id_notification)
    {
        if (empty($id_account_list))
        {
            return;
        }

        $data = SharedFunctions::setUpNotificationAccountData($id_account_list, $id_notification);
        $this->notificationAccountDepository->insertMultiple($data);
    }


    public function getNotificationsApp ($id_account, $id_notification = '0') : array
    {
        $data              = $this->notificationAccountDepository->getNotifications($id_account, $id_notification);
        $data              = SharedFunctions::formatGetNotificationResponse($data);
        $data_version      = $this->dataVersionStudentDepository->getSingleColumn($id_account, 'notification');
        $data['index_del'] = $this->_getDeletedNotifications($id_notification);

        return [
            'data'         => $data,
            'data_version' => $data_version
        ];
    }

    private function _getDeletedNotifications ($id_notification) : array
    {
        if ($id_notification != '0')
        {
            return $this->notificationDepository->getDeletedNotifications();
        }
        else
        {
            return [];
        }
    }

    public function setDelete ($id_notification_list)
    {
        $this->notificationDepository->setDelete($id_notification_list);
        $id_student_list = $this->notificationAccountDepository->getIDAccounts($id_notification_list);
        $this->_updateNotificationVersion($id_student_list);
    }

    private function _updateNotificationVersion ($id_student_list)
    {
        $this->dataVersionStudentDepository->updateMultiple($id_student_list, 'notification');
    }


    public function getNotificationsWeb ($id_sender, $num)
    {
        return $this->notificationDepository->getNotifications($id_sender, $num);
    }
}

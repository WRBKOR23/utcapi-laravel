<?php


namespace App\Services;


use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\DataVersionTeacherRepositoryContract;
use App\Repositories\Contracts\NotificationAccountRepositoryContract;
use App\Repositories\Contracts\NotificationRepositoryContract;
use App\Repositories\Contracts\ParticipateRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\NotificationServiceContract;

class NotificationService implements NotificationServiceContract
{
    private NotificationAccountRepositoryContract $notificationAccountRepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;
    private DataVersionTeacherRepositoryContract $dataVersionTeacherRepository;
    private NotificationRepositoryContract $notificationRepository;
    private ParticipateRepositoryContract $participateRepository;
    private AccountRepositoryContract $accountRepository;
    private StudentRepositoryContract $studentRepository;

    /**
     * @param NotificationAccountRepositoryContract $notificationAccountRepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     * @param DataVersionTeacherRepositoryContract $dataVersionTeacherRepository
     * @param NotificationRepositoryContract $notificationRepository
     * @param ParticipateRepositoryContract $participateRepository
     * @param AccountRepositoryContract $accountRepository
     * @param StudentRepositoryContract $studentRepository
     */
    public function __construct (NotificationAccountRepositoryContract $notificationAccountRepository,
                                 DataVersionStudentRepositoryContract  $dataVersionStudentRepository,
                                 DataVersionTeacherRepositoryContract  $dataVersionTeacherRepository,
                                 NotificationRepositoryContract        $notificationRepository,
                                 ParticipateRepositoryContract         $participateRepository,
                                 AccountRepositoryContract             $accountRepository,
                                 StudentRepositoryContract             $studentRepository)
    {
        $this->notificationAccountRepository = $notificationAccountRepository;
        $this->dataVersionStudentRepository  = $dataVersionStudentRepository;
        $this->dataVersionTeacherRepository  = $dataVersionTeacherRepository;
        $this->notificationRepository        = $notificationRepository;
        $this->participateRepository         = $participateRepository;
        $this->accountRepository             = $accountRepository;
        $this->studentRepository             = $studentRepository;
    }

    public function pushNotificationBFC ($notification, $class_list) : array
    {
        $id_student_list = $this->_getIDStudentsBFC($class_list);
        $id_account_list = $this->_sharedFunctions($notification, $id_student_list);

        return $id_account_list;
    }

    private function _getIDStudentsBFC ($class_list)
    {
        return $this->studentRepository->getIDStudentsBFC($class_list);
    }

    public function pushNotificationBMC ($notification, $class_list) : array
    {
        $id_student_list = $this->_getIDStudentsBMC($class_list);
        $id_account_list = $this->_sharedFunctions($notification, $id_student_list);

        return $id_account_list;
    }

    private function _getIDStudentsBMC ($class_list)
    {
        return $this->participateRepository->getIDStudentsBMC($class_list);
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

        return $this->accountRepository->getIDAccounts($id_student_list);
    }

    private function _insertNotification ($notification)
    {
        $notification = SharedFunctions::setUpNotificationData($notification);
        return $this->notificationRepository->insertGetID($notification);
    }

    private function _insertNotificationAccount ($id_account_list, $id_notification)
    {
        if (empty($id_account_list))
        {
            return;
        }

        $data = SharedFunctions::setUpNotificationAccountData($id_account_list, $id_notification);
        $this->notificationAccountRepository->insertMultiple($data);
    }


    public function getNotificationByReceiver ($id_account, $is_student, $id_notification = '0') : array
    {
        $data = $this->notificationAccountRepository->getNotifications($id_account, $id_notification);
        $data = SharedFunctions::formatGetNotificationResponse($data);
        if ($is_student)
        {
            $data_version = $this->dataVersionStudentRepository->getSingleColumn1($id_account, 'notification');
        }
        else
        {
            $data_version = $this->dataVersionTeacherRepository->getSingleColumn1($id_account, 'notification');
        }
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
            return $this->notificationRepository->getDeletedNotifications();
        }
        else
        {
            return [];
        }
    }

    public function setDelete ($id_notification_list)
    {
        $this->notificationRepository->setDelete($id_notification_list);
        $id_student_list = $this->notificationAccountRepository->getIDAccounts($id_notification_list);
        $this->_updateNotificationVersion($id_student_list);
    }

    private function _updateNotificationVersion ($id_student_list)
    {
        $this->dataVersionStudentRepository->updateMultiple($id_student_list, 'notification');
    }


    public function getNotificationBySender ($id_sender, $num)
    {
        return $this->notificationRepository->getNotifications($id_sender, $num);
    }
}

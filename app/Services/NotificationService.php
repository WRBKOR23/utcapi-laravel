<?php

namespace App\Services;

use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\DataVersionTeacherRepositoryContract;
use App\Repositories\Contracts\NotificationRepositoryContract;

class NotificationService implements Contracts\NotificationServiceContract
{
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;
    private DataVersionTeacherRepositoryContract $dataVersionTeacherRepository;
    private NotificationRepositoryContract $notificationRepository;

    /**
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     * @param DataVersionTeacherRepositoryContract $dataVersionTeacherRepository
     * @param NotificationRepositoryContract       $notificationRepository
     */
    public function __construct (DataVersionStudentRepositoryContract $dataVersionStudentRepository,
                                 DataVersionTeacherRepositoryContract $dataVersionTeacherRepository,
                                 NotificationRepositoryContract       $notificationRepository)
    {
        $this->dataVersionStudentRepository = $dataVersionStudentRepository;
        $this->dataVersionTeacherRepository = $dataVersionTeacherRepository;
        $this->notificationRepository       = $notificationRepository;
    }

    public function getNotificationByReceiver ($id_account, $is_student,
                                               $id_notification_offset) : array
    {
        $id_notifications = $this->notificationRepository->getIDNotifications($id_account,
                                                                              $id_notification_offset);
        $notifications    = $this->notificationRepository->getNotifications($id_notifications);

        $indexes_deleted = $this->_getDeletedNotifications($id_notification_offset);
        $notifications   = $this->_formatNotificationResponse($notifications, $indexes_deleted);
        $data_version    = $this->_getNotificationDataVersion($is_student, $id_account);

        return [
            'notifications' => $notifications,
            'data_version'  => $data_version
        ];
    }

    private function _formatNotificationResponse ($data, $indexes_deleted) : array
    {
        $response = [];
        foreach ($data as $part)
        {
            foreach ($part as $notification)
            {
                $response['senders'][] = [
                    'id_sender'   => $notification['id_sender'],
                    'sender_name' => $notification['sender_name'],
                ];
                unset($notification['sender_name']);

                $response['notifications'][] = $notification;
            }
        }

        if (isset($response['senders']))
        {
            $response['senders'] = array_values(array_unique($response['senders'], SORT_REGULAR));
        }
        $response['indexes_deleted'] = $indexes_deleted;

        return $response;
    }

    private function _getNotificationDataVersion ($is_student, $id_account)
    {
        if ($is_student)
        {
            return $this->dataVersionStudentRepository->getSingleColumn1($id_account,
                                                                         'notification');
        }
        else
        {
            return $this->dataVersionTeacherRepository->getSingleColumn1($id_account,
                                                                         'notification');
        }
    }

    private function _getDeletedNotifications ($id_notification_offset) : array
    {
        if ($id_notification_offset != '0')
        {
            return $this->notificationRepository->getDeletedNotifications();
        }
        else
        {
            return [];
        }
    }
}

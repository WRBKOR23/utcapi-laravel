<?php

namespace App\Services\Contracts;

interface NotificationServiceContract
{
    public function getNotificationByReceiver ($id_account, $is_student, $id_notification_offset);
}

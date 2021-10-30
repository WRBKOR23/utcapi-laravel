<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\OtherDepartment;
use App\Models\Teacher;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository implements Contracts\NotificationRepositoryContract
{
    public function getIDNotifications ($id_account, $id_notification_offset)
    {
        return Account::find($id_account)->notifications()
                      ->where('notification.id', '>', $id_notification_offset)
                      ->pluck('id_notification')->toArray();
    }

    public function getNotifications ($id_notifications) : array
    {
        $result = [];

        $result[] = Notification::whereIn('notification.id', $id_notifications)
                                ->join(Account::table_as, 'id_sender', 'acc.id')
                                ->join(OtherDepartment::table_as, 'id_sender', 'od.id_account')
                                ->get(['notification.*',
                                       'od.other_department_name as sender_name'])->toArray();

        $result[] = Notification::whereIn('notification.id', $id_notifications)
                                ->join(Account::table_as, 'id_sender', 'acc.id')
                                ->join(Faculty::table_as, 'id_sender', 'fac.id_account')
                                ->get(['notification.*',
                                       'fac.faculty_name as sender_name'])->toArray();

        $result[] = Notification::whereIn('notification.id', $id_notifications)
                                ->join(Account::table_as, 'id_sender', 'acc.id')
                                ->join(Department::table_as, 'id_sender', 'dep.id_account')
                                ->get(['notification.*',
                                       'dep.department_name as sender_name'])->toArray();

        $result[] = Notification::whereIn('notification.id', $id_notifications)
                                ->join(Account::table_as, 'id_sender', 'acc.id')
                                ->join(Teacher::table_as, 'id_sender', 'tea.id_account')
                                ->get(['notification.*',
                                       'tea.teacher_name as sender_name'])->toArray();

        return $result;
    }

    public function getDeletedNotifications ()
    {
        return Notification::where('is_delete', true)
                           ->where('time_create', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 3 WEEK)'))
                           ->pluck('id')->toArray();
    }
}

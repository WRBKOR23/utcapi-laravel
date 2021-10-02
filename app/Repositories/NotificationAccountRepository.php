<?php

namespace App\Repositories;

use App\Repositories\Contracts\NotificationAccountRepositoryContract;
use App\Models\Account;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\NotificationAccount;
use App\Models\OtherDepartment;
use App\Models\Student;
use App\Models\Teacher;

class NotificationAccountRepository implements NotificationAccountRepositoryContract
{
    public function insertMultiple ($data)
    {
        NotificationAccount::insert($data);
    }

    public function getIDAccounts ($id_notification_list)
    {
        return NotificationAccount::whereIn('notification_account.id_notification', $id_notification_list)
                                  ->join(Student::table_as, 'notification_account.id_account', '=', 'stu.id_account')
                                  ->pluck('id_student');
    }

    public function getNotifications ($id_account, $id_notification = '0') : array
    {
        $result = [];

        $result[] = Account::find($id_account)->notifications()
                           ->where('notification.id_notification', '>', $id_notification)
                           ->join(Account::table_as, 'id_sender', '=', 'acc.id_account')
                           ->join(OtherDepartment::table_as, 'id_sender', '=', 'od.id_account')
                           ->select('notification.*',
                                    'od.other_department_name as sender_name',
                                    'acc.permission')
                           ->get()
                           ->toArray();

        $result[] = Account::find($id_account)->notifications()
                           ->where('notification.id_notification', '>', $id_notification)
                           ->join(Account::table_as, 'id_sender', '=', 'acc.id_account')
                           ->join(Department::table_as, 'id_sender', '=', 'dep.id_account')
                           ->select('notification.*',
                                    'dep.department_name as sender_name',
                                    'acc.permission')
                           ->get()
                           ->toArray();

        $result[] = Account::find($id_account)->notifications()
                           ->where('notification.id_notification', '>', $id_notification)
                           ->join(Account::table_as, 'id_sender', '=', 'acc.id_account')
                           ->join(Teacher::table_as, 'id_sender', '=', 'tea.id_account')
                           ->select('notification.*',
                                    'tea.teacher_name as sender_name',
                                    'acc.permission')
                           ->get()
                           ->toArray();

        $result[] = Account::find($id_account)->notifications()
                           ->where('notification.id_notification', '>', $id_notification)
                           ->join(Account::table_as, 'id_sender', '=', 'acc.id_account')
                           ->join(Faculty::table_as, 'id_sender', '=', 'fac.id_account')
                           ->select('notification.*',
                                    'fac.faculty_name as sender_name',
                                    'acc.permission')
                           ->get()
                           ->toArray();

        return $result;
    }
}

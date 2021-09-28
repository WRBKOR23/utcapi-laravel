<?php

namespace App\Depositories;

use App\Depositories\Contracts\NotificationAccountDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Models\Account;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\NotificationAccount;
use App\Models\OtherDepartment;
use App\Models\Teacher;
use Illuminate\Support\Collection;

class NotificationAccountDepository implements NotificationAccountDepositoryContract
{
    // NotificationAccount Model
    private NotificationAccount $model;

    public function __construct (NotificationAccount $model)
    {
        $this->model = $model;
    }

    public function insertMultiple ($data)
    {
        NotificationAccount::insert($data);
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

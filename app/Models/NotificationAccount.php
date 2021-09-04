<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;

    class NotificationAccount extends Model
    {
        use HasFactory;

        public const table = 'notification_account';
        public const table_as = 'notification_account as na';

        public function insertMultiple ($arr)
        {
            DB::table(self::table)
                ->insert($arr);
        }

        public function getIDAccounts ($id_notification_list) : array
        {
            return DB::table(self::table)
                ->whereIn('id_notification', $id_notification_list)
                ->pluck('id_account')
                ->toArray();
        }

        public function getNotifications ($id_account, $id_notification = '0') : array
        {
            $noti_na = DB::table(self::table_as)
                ->join(Notification::table_as, function ($join) use ($id_notification)
                {
                    $join->on('na.id_notification', '=', 'noti.id_notification')
                        ->where('noti.id_notification', '>', $id_notification);
                })
                ->where('na.id_account', '=', $id_account)
                ->select('noti.*');

            $query_1 = DB::table(OtherDepartment::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('od.id_account', '=', 'noti_na.id_sender');
                })
                ->join(Account::table_as, 'od.id_account', '=', 'acc.id_account')
                ->select('noti_na.*',
                    'od.other_department_name as sender_name',
                    'acc.permission');

            $query_2 = DB::table(Department::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('dep.id_account', '=', 'noti_na.id_sender');
                })
                ->join(Account::table_as, 'dep.id_account', '=', 'acc.id_account')
                ->select('noti_na.*',
                    'dep.department_name as sender_name',
                    'acc.permission');

            $query_3 = DB::table(Faculty::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('fac.id_account', '=', 'noti_na.id_sender');
                })
                ->join(Account::table_as, 'fac.id_account', '=', 'acc.id_account')
                ->select('noti_na.*',
                    DB::raw('CONCAT(\'Khoa \', fac.faculty_name) as sender_name'),
                    'acc.permission');

            return DB::table(Teacher::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('tea.id_account', '=', 'noti_na.id_sender');
                })
                ->join(Account::table_as, 'tea.id_account', '=', 'acc.id_account')
                ->select('noti_na.*',
                    DB::raw('concat(\'Gv.\', tea.teacher_name) as sender_name'),
                    'acc.permission')
                ->union($query_1)
                ->union($query_2)
                ->union($query_3)
                ->get()
                ->toArray();
        }
    }

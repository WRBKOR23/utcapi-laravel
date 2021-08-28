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
                ->whereIn('ID_Notification', $id_notification_list)
                ->pluck('ID_Account')
                ->toArray();
        }

        public function getNotifications ($id_account, $id_notification = '0') : array
        {
            $noti_na = DB::table(self::table_as)
                ->join(Notification::table_as, function ($join) use ($id_notification)
                {
                    $join->on('na.ID_Notification', '=', 'noti.ID_Notification')
                        ->where('noti.ID_Notification', '>', $id_notification);
                })
                ->where('na.ID_Account', '=', $id_account)
                ->select('noti.*');

            $query_1 = DB::table(OtherDepartment::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('od.ID_Account', '=', 'noti_na.ID_Sender');
                })
                ->join(Account::table_as, 'od.ID_Account', '=', 'acc.id')
                ->select('noti_na.*',
                    'od.Other_Department_Name as Sender_Name',
                    'acc.permission');

            $query_2 = DB::table(Department::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('dep.ID_Account', '=', 'noti_na.ID_Sender');
                })
                ->join(Account::table_as, 'dep.ID_Account', '=', 'acc.id')
                ->select('noti_na.*',
                    'dep.Department_Name as Sender_Name',
                    'acc.permission');

            $query_3 = DB::table(Faculty::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('fac.ID_Account', '=', 'noti_na.ID_Sender');
                })
                ->join(Account::table_as, 'fac.ID_Account', '=', 'acc.id')
                ->select('noti_na.*',
                    DB::raw('CONCAT(\'Khoa \', fac.Faculty_Name) as Sender_Name'),
                    'acc.permission');

            return DB::table(Teacher::table_as)
                ->joinSub($noti_na, 'noti_na', function ($join)
                {
                    $join->on('tea.ID_Account', '=', 'noti_na.ID_Sender');
                })
                ->join(Account::table_as, 'tea.ID_Account', '=', 'acc.id')
                ->select('noti_na.*',
                    DB::raw('concat(\'Gv.\', tea.Name_Teacher) as Sender_Name'),
                    'acc.permission')
                ->union($query_1)
                ->union($query_2)
                ->union($query_3)
                ->get()
                ->toArray();
        }
    }

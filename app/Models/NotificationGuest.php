<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NotificationGuest extends Model
{
    use HasFactory;

    public const table = 'notification_guest';
    public const table_as = 'notification_guest as ng';

    public function insertMultiple($data)
    {
        DB::table(self::table)
            ->insert($data);
    }

    public function getIDNotifications ($id_guest, $id_notification): array
    {
        return DB::connection('mysql2')->table(self::table)
            ->where('ID_Guest', '=', $id_guest)
            ->where('ID_Notification', '>', $id_notification)
            ->pluck('ID_Notification')
            ->toArray();
    }

    public function getNotifications ($id_notification_list) : array
    {
        $noti = DB::table(Notification::table)
            ->whereIn('ID_Notification', $id_notification_list)
            ->select();

        $query_1 = DB::table(OtherDepartment::table_as)
            ->joinSub($noti, 'noti', function ($join)
            {
                $join->on('od.ID_Account', '=', 'noti.ID_Sender');
            })
            ->join(Account::table_as, 'od.ID_Account', '=', 'acc.id_account')
            ->select('noti.*',
                     'od.Other_Department_Name as Sender_Name',
                     'acc.permission');

        $query_2 = DB::table(Department::table_as)
            ->joinSub($noti, 'noti', function ($join)
            {
                $join->on('dep.ID_Account', '=', 'noti.ID_Sender');
            })
            ->join(Account::table_as, 'dep.ID_Account', '=', 'acc.id_account')
            ->select('noti.*',
                     'dep.Department_Name as Sender_Name',
                     'acc.permission');

        $query_3 = DB::table(Faculty::table_as)
            ->joinSub($noti, 'noti', function ($join)
            {
                $join->on('fac.ID_Account', '=', 'noti.ID_Sender');
            })
            ->join(Account::table_as, 'fac.ID_Account', '=', 'acc.id_account')
            ->select('noti.*',
                     DB::raw('CONCAT(\'Khoa \', fac.Faculty_Name) as Sender_Name'),
                     'acc.permission');

        return DB::table(Teacher::table_as)
            ->joinSub($noti, 'noti', function ($join)
            {
                $join->on('tea.ID_Account', '=', 'noti.ID_Sender');
            })
            ->join(Account::table_as, 'tea.ID_Account', '=', 'acc.id_account')
            ->select('noti.*',
                     DB::raw('concat(\'Gv.\', tea.Name_Teacher) as Sender_Name'),
                     'acc.permission')
            ->union($query_1)
            ->union($query_2)
            ->union($query_3)
            ->get()
            ->toArray();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;

    public const table = 'notification';
    public const table_as = 'notification as noti';

    public function insertGetID ($data): int
    {
        return DB::table(self::table)
            ->insertGetId($data);
    }

    public function setDelete ($id_notification_list)
    {
        DB::table(self::table)
            ->whereIn('ID_Notification', $id_notification_list)
            ->update(['Is_Delete' => 1]);
    }

    public function getNotifications ($id_sender, $num): Collection
    {
        return DB::table(self::table)
            ->where('ID_Sender', '=', $id_sender)
            ->where('Is_Delete', '=', 0)
            ->orderBy('ID_Notification')
            ->offset($num)
            ->limit(15)
            ->select('ID_Notification', 'Title', 'Content',
                'Time_Create', 'Time_Start', 'Time_End')
            ->get();
    }

}

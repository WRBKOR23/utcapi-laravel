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
            ->whereIn('id_notification', $id_notification_list)
            ->update(['is_delete' => 1]);
    }

    public function getNotifications ($id_sender, $num): Collection
    {
        return DB::table(self::table)
            ->where('id_sender', '=', $id_sender)
            ->where('is_delete', '=', 0)
            ->orderBy('id_notification', 'desc')
            ->offset($num)
            ->limit(15)
            ->select('id_notification', 'title', 'content',
                'time_create', 'time_start', 'time_end')
            ->get();
    }

}

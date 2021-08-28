<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GuestInfo extends Model
{
    use HasFactory;

    public const table = 'guest_info';
    public const table_as = 'guest_info as gi';

    public function upsert ($data)
    {
        DB::connection('mysql2')->table(self::table)
            ->updateOrInsert(['ID_Student' => $data['ID_Student']], $data);
    }

    public function updatePassword ($id_student, $password)
    {
        DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->update(['Password' => $password]);
    }

    public function updateDeviceToken ($id_student, $device_token)
    {
        DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->update(['Device_Token' => $device_token]);
    }

    public function updateDataVersion ($id_student, $type)
    {
        DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->increment($type);
    }

    public function updateDataVersionMultiple ($id_guest_list, $type)
    {
        DB::connection('mysql2')->table(self::table)
            ->whereIn('ID', $id_guest_list)
            ->increment($type, 1);
    }

    public function get ($id_student)
    {
        return DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->select('ID as ID_Account', 'ID_Student', 'Student_Name', 'Permission')
            ->get()
            ->first();
    }

    public function getPassword ($id_student)
    {
        return DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->pluck('Password')
            ->first();
    }

    public function getDeviceTokens ($id_guest_list): array
    {
        return DB::connection('mysql2')->table(self::table)
            ->whereIn('ID', $id_guest_list)
            ->pluck('Device_Token')
            ->toArray();
    }

    public function getIDGuests ($id_faculty_list, $academic_year_list): array
    {
        return DB::connection('mysql2')->table(self::table)
            ->whereIn('ID_Faculty', $id_faculty_list)
            ->whereIn('Academic_Year', $academic_year_list)
            ->pluck('ID')
            ->toArray();
    }

    public function getNotificationVersion ($id_student)
    {
        return DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->pluck('Notification_Data_Version')
            ->first();
    }

    public function getDataVersion ($id_student)
    {
        return DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->select('Notification_Data_Version as Notification',
                     'Module_Score_Data_Version as Module_Score',
                     'Exam_Schedule_Data_Version as Exam_Schedule')
            ->first();
    }
}

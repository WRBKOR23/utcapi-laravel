<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FixedSchedule extends Model
{
    use HasFactory;

    public const table = 'fix';
    public const table_as = 'fix as fix';

    public function getFixSchedules ($last_time_accepted)
    {

//        $t1 = DB::table(self::table_as)
//            ->join(Room::table_as, 'fix.ID_Room', '=', 'room.ID_Room')
//            ->where('fix.Time_Accept_Request', '>', $last_time_accepted)
//            ->whereNotNull('fix.Time_Accept_Request')
//            ->where('fix.Status_Fix', '=', 'Chấp nhận')
//            ->select('fix.Time_Accept_Request', 'fix.ID_Schedule', 'fix.Day_Fix', 'room.Room_Name');
//
//        $t2 = DB::table(Schedule::table_as)
//            ->joinSub($t1, 't1', function ($join)
//            {
//                $join->on('sdu.ID_Schedule', '=', 't1.ID_Schedule');
//            })
//            ->join(ModuleClass::table_as, 'sdu.ID_Module_Class', '=', 'mc.ID_Module_Class')
//            ->select('t1.*', 'mc.ID_Module_Class',
//                     'sch.Day_Schedules', 'sch.Shift_Schedules',)
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    public const table = 'schedules';
    public const table_as = 'schedules as sdu';

    public function getStudentSchedules ($id_student): Collection
    {
        $mc_t = DB::table(ModuleClass::table_as)
            ->join(Participate::table_as, function ($join) use ($id_student) {
                $join->on('mc.ID_Module_Class', '=', 'par.ID_Module_Class')
                    ->where('par.ID_Student', '=', $id_student);
            })
            ->leftJoin(Teacher::table_as, 'mc.ID_Teacher', '=', 'tea.ID_Teacher')
            ->select('mc.ID_Module_Class', 'Module_Class_Name', 'Name_Teacher');

        return DB::table(self::table_as)
            ->joinSub($mc_t, 'mc_t', function ($join) {
                $join->on('sdu.ID_Module_Class', '=', 'mc_t.ID_Module_Class');
            })
            ->where('sdu.Day_Schedules', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
            ->orderBy('sdu.ID_Module_Class')
            ->select('sdu.ID_Schedules', 'mc_t.Module_Class_Name', 'sdu.ID_Module_Class',
                'sdu.ID_Room', 'sdu.Shift_Schedules', 'sdu.Day_Schedules', 'mc_t.Name_Teacher')
            ->get();
    }

    public function getTeacherSchedules ($id_teacher): Collection
    {
        $mc_t = DB::table(ModuleClass::table . ' as mc')
            ->join(Teacher::table_as, function ($join) use ($id_teacher) {
                $join->on('mc.ID_Teacher', '=', 'tea.ID_Teacher')
                    ->where('tea.ID_Teacher', '=', $id_teacher);
            })
            ->select('ID_Module_Class', 'Module_Class_Name');

        return DB::table(self::table . ' as sdu')
            ->joinSub($mc_t, 'mc_t', function ($join) {
                $join->on('sdu.ID_Module_Class', '=', 'mc_t.ID_Module_Class');
            })
            ->where('sdu.Day_Schedules', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
            ->orderBy('sdu.ID_Module_Class')
            ->select('sdu.ID_Schedules', 'mc_t.Module_Class_Name', 'sdu.ID_Module_Class',
                'sdu.ID_Room', 'sdu.Shift_Schedules', 'sdu.Day_Schedules')
            ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    public const table = 'schedule';
    public const table_as = 'schedule as sdu';

    public function getStudentSchedules ($id_student): Collection
    {
        $mc_t = DB::table(ModuleClass::table_as)
            ->join(Participate::table_as, function ($join) use ($id_student) {
                $join->on('mc.id_module_class', '=', 'par.id_module_class')
                    ->where('par.id_student', '=', $id_student);
            })
            ->leftJoin(Teacher::table_as, 'mc.id_teacher', '=', 'tea.id_teacher')
            ->select('mc.id_module_class', 'module_class_name', 'teacher_name');

        return DB::table(self::table_as)
            ->joinSub($mc_t, 'mc_t', function ($join) {
                $join->on('sdu.id_module_class', '=', 'mc_t.id_module_class');
            })
            ->where('sdu.date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
            ->orderBy('sdu.id_module_class')
            ->select('sdu.id_schedule', 'mc_t.module_class_name', 'sdu.id_module_class',
                'sdu.id_room', 'sdu.shift', 'sdu.date', 'mc_t.teacher_name')
            ->get();
    }

    public function getTeacherSchedules ($id_teacher): Collection
    {
        $mc_t = DB::table(ModuleClass::table . ' as mc')
            ->join(Teacher::table_as, function ($join) use ($id_teacher) {
                $join->on('mc.id_teacher', '=', 'tea.id_teacher')
                    ->where('tea.id_teacher', '=', $id_teacher);
            })
            ->select('id_module_class', 'module_class_name');

        return DB::table(self::table . ' as sdu')
            ->joinSub($mc_t, 'mc_t', function ($join) {
                $join->on('sdu.id_module_class', '=', 'mc_t.id_module_class');
            })
            ->where('sdu.date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
            ->orderBy('sdu.id_module_class')
            ->select('sdu.id_schedule', 'mc_t.module_class_name', 'sdu.id_module_class',
                'sdu.id_room', 'sdu.shift', 'sdu.date')
            ->get();
    }
}

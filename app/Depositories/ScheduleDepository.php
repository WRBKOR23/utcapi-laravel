<?php

namespace App\Depositories;

use App\Depositories\Contracts\ScheduleDepositoryContract;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ScheduleDepository implements ScheduleDepositoryContract
{
    // Schedule Model
    private Schedule $model;

    public function __construct (Schedule $model)
    {
        $this->model = $model;
    }

    public function getStudentSchedules ($id_student) : Collection
    {
        return Student::find($id_student)->moduleClasses()
                      ->join(Schedule::table_as, 'module_class.id_module_class', '=', 'sdu.id_module_class')
                      ->where('sdu.date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
                      ->leftJoin(Teacher::table_as, 'tea.id_teacher', '=', 'module_class.id_teacher')
                      ->orderBy('sdu.id_module_class')
                      ->orderBy('sdu.id_schedule')
                      ->select('sdu.id_schedule', 'sdu.id_module_class', 'module_class_name',
                               'sdu.id_room', 'sdu.shift', 'sdu.date', 'teacher_name')
                      ->get();
    }

    public function getTeacherSchedules ($id_teacher) : Collection
    {
        return Teacher::find($id_teacher)->moduleClasses()
                      ->join(Schedule::table_as, 'module_class.id_module_class', '=', 'sdu.id_module_class')
                      ->where('sdu.date', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 YEAR)'))
                      ->orderBy('sdu.id_module_class')
                      ->orderBy('sdu.id_schedule')
                      ->select('sdu.id_schedule', 'sdu.id_module_class', 'module_class.module_class_name',
                               'sdu.id_room', 'sdu.shift', 'sdu.date')
                      ->get();
    }
}
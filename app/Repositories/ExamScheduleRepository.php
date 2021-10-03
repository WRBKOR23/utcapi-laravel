<?php

namespace App\Repositories;

use App\Models\ExamSchedule;
use App\Models\Student;
use App\Repositories\Contracts\ExamScheduleRepositoryContract;
use Illuminate\Support\Collection;

class ExamScheduleRepository implements ExamScheduleRepositoryContract
{
    public function get ($id_student) : Collection
    {
        return Student::find($id_student)->examSchedules()
                      ->orderBy('date_start')
                      ->select('id as id_exam_schedule', 'school_year', 'module_name',
                               'credit', 'date_start', 'time_start',
                               'method', 'identification_number', 'room')
                      ->get();
    }

    public function getLatestSchoolYear ($id_student)
    {
        return ExamSchedule::where('id_student', '=', $id_student)
                           ->distinct()
                           ->orderBy('school_year', 'desc')
                           ->pluck('school_year')
                           ->first();
    }

    public function insertMultiple ($data)
    {
        ExamSchedule::insert($data);
    }

    public function upsert ($data)
    {
        ExamSchedule::upsert($data,
                             ['school_year', 'id_module_class', 'id_student'],
                             [
                                 'date_start', 'time_start', 'method',
                                 'identification_number', 'room'
                             ]);
    }

    public function delete ($id_student, $school_year)
    {
        ExamSchedule::where('id_student', '=', $id_student)
                    ->where('school_year', '=', $school_year)
                    ->delete();
    }
}

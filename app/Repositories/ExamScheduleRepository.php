<?php

namespace App\Repositories;

use App\Models\ExamSchedule;
use App\Models\Student;
use Illuminate\Support\Collection;

class ExamScheduleRepository implements Contracts\ExamScheduleRepositoryContract
{
    public function insertMultiple ($exam_schedules)
    {
        ExamSchedule::insert($exam_schedules);
    }

    public function upsert ($exam_schedule)
    {
        ExamSchedule::upsert($exam_schedule,
                             ['term', 'id_module_class', 'id_student'],
                             [
                                 'date_start', 'time_start', 'method',
                                 'identification_number', 'room'
                             ]);
    }

    public function get ($id_student) : Collection
    {
        return Student::find($id_student)->examSchedules()->orderBy('date_start')
                      ->get(['id as id_exam_schedule', 'term', 'module_name',
                             'credit', 'date_start', 'time_start',
                             'method', 'identification_number', 'room']);
    }

    public function getLatestTerm ($id_student)
    {
        return ExamSchedule::where('id_student', $id_student)->max('id_term');
    }

    public function delete ($id_student, $id_term)
    {
        ExamSchedule::where('id_student', $id_student)
                    ->where('id_term', $id_term)
                    ->delete();
    }
}

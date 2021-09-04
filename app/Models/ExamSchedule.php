<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExamSchedule extends Model
{
    use HasFactory;

    public const table = 'exam_schedule';
    public const table_as = 'exam_schedule as es';

    public function get ($id_student) : Collection
    {
        return DB::connection('mysql2')->table(self::table)
            ->where('id_student', '=', $id_student)
            ->orderBy('date_start')
            ->select('id_exam_schedule', 'school_year', 'module_name', 'credit', 'date_start',
                'time_start', 'method', 'identification_number', 'room')
            ->get();
    }

    public function insertMultiple ($data)
    {
        DB::connection('mysql2')->table(self::table)
            ->insert($data);
    }

    public function upsert ($data)
    {
        DB::connection('mysql2')->table(self::table)
            ->updateOrInsert([
                'school_year' => $data['school_year'],
                'id_module' => $data['id_module'],
                'id_student' => $data['id_student']
            ], $data);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ExamScheduleGuest extends Model
{
    use HasFactory;

    public const table = 'exam_schedule_guest';
    public const table_as = 'exam_schedule_guest as esg';

    public function get ($id_student) : Collection
    {
        return DB::connection('mysql2')->table(self::table)
            ->where('ID_Student', '=', $id_student)
            ->orderBy('Date_Start')
            ->select('ID', 'School_Year', 'Module_Name', 'Credit', 'Date_Start',
                     'Time_Start', 'Method', 'Identification_Number', 'Room')
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
                                 'School_Year' => $data['School_Year'],
                                 'ID_Module' => $data['ID_Module'],
                                 'ID_Student' => $data['ID_Student']
                             ], $data);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Class_ extends Model
{
    use HasFactory;

    public const table = 'class';
    public const table_as = 'class as cl';

    public function getAcademicYear (): array
    {
        return DB::table('class')
            ->orderBy('academic_year', 'desc')
            ->limit(9)
            ->distinct()
            ->pluck('academic_year')
            ->toArray();
    }

    public function getFacultyClass ($academic_year_list): Collection
    {
        $this->_createTemporaryTable($academic_year_list);

        return DB::table('class as c')
            ->join('temp as t', 'c.academic_year', '=', 't.academic_year')
            ->orderBy('academic_year')
            ->orderBy('id_faculty')
            ->orderBy('id_class')
            ->select('c.academic_year', 'id_faculty', 'id_class')
            ->get();
    }

    private function _createTemporaryTable ($academic_year_list)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp (
                  academic_year varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        $arr = [];
        foreach ($academic_year_list as $academic_year)
        {
            $arr[] = ['academic_year' => $academic_year];
        }

        DB::unprepared($sql_query);

        DB::table('temp')
            ->insert($arr);
    }

    public function upsert($data)
    {
        DB::table(self::table)
            ->updateOrInsert(['id_class' => $data['id_class']],$data);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'INSERT INTO
                ' . self::table . '
            (
                id_class, academic_year, class_name, id_faculty
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE id_class = id_class';

        DB::insert($sql_query, $data);
    }
}

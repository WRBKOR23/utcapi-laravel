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
            ->orderBy('Academic_Year', 'desc')
            ->limit(9)
            ->distinct()
            ->pluck('Academic_Year')
            ->toArray();
    }

    public function getFacultyClass ($academic_year_list): Collection
    {
        $this->_createTemporaryTable($academic_year_list);

        return DB::table('class as c')
            ->join('temp as t', 'c.Academic_Year', '=', 't.Academic_Year')
            ->orderBy('Academic_Year')
            ->orderBy('ID_Faculty')
            ->orderBy('ID_Class')
            ->select('c.Academic_Year', 'ID_Faculty', 'ID_Class')
            ->get();
    }

    private function _createTemporaryTable ($academic_year_list)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp (
                  Academic_Year varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        $arr = [];
        foreach ($academic_year_list as $academic_year)
        {
            $arr[] = ['Academic_Year' => $academic_year];
        }

        DB::unprepared($sql_query);

        DB::table('temp')
            ->insert($arr);
    }

    public function upsert($data)
    {
        DB::table(self::table)
            ->updateOrInsert(['ID_Class' => $data['ID_Class']],$data);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $sql_query =
            'INSERT INTO
                ' . self::table . '
            (
                ID_Class, Academic_Year, Class_Name, ID_Faculty
            )
            VALUES
                ' . $part_of_sql . '
            ON DUPLICATE KEY UPDATE ID_Class = ID_Class';

        DB::insert($sql_query, $data);
    }
}

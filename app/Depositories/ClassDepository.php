<?php

namespace App\Depositories;

use App\Models\Class_;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClassDepository implements Contracts\ClassDepositoryContract
{
    private Class_ $model;

    /**
     * ClassDepository constructor.
     * @param Class_ $model
     */
    public function __construct (Class_ $model)
    {
        $this->model = $model;
    }

    public function getAcademicYears () : array
    {
        return Class_::orderBy('academic_year')
                     ->distinct()
                     ->limit(9)
                     ->pluck('academic_year')
                     ->toArray();
    }

    public function getFacultyClass ($academic_year_list) : Collection
    {
        $this->_createTemporaryTable($academic_year_list);

        return Class_::join('temp as t', 'class.academic_year', '=', 't.academic_year')
                 ->orderBy('academic_year')
                 ->orderBy('id_faculty')
                 ->orderBy('id_class')
                 ->select('class.academic_year', 'id_faculty', 'id_class')
                 ->get();
    }

    public function insertMultiple ($data)
    {
        Class_::upsert($data, ['id_class'], ['id_class']);
    }

    public function upsert ($data)
    {
        Class_::updateOrCreate(['id_class' => $data['id_class']], $data);
    }

    private function _createTemporaryTable ($academic_year_list)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp (
                  academic_year varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

        DB::unprepared($sql_query);
        DB::table('temp')->insert($academic_year_list);
    }
}

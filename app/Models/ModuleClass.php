<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ModuleClass extends Model
{
    public const table = 'module_class';
    public const table_as = 'module_class as mc';

    public function getModuleClass ($first_school_year, $second_school_year): Collection
    {
        $this->_createTemporaryTable($first_school_year, $second_school_year);

        return DB::table(self::table_as)
            ->join('temp as t', 'mc.School_Year', '=', 't.School_Year')
            ->orderBy('ID_Module_Class')
            ->select('ID_Module_Class', 'Module_Class_Name')
            ->get();
    }

    private function _createTemporaryTable ($first_school_year, $second_school_year)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp(
                     School_Year varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE = InnoDB default CHARSET = utf8 COLLATE = utf8_unicode_ci';

        DB::unprepared($sql_query);

        DB::table('temp')
            ->insert([
                ['School_Year' => $first_school_year],
                ['School_Year' => $second_school_year]
            ]);
    }

    public function getLatestSchoolYear ()
    {
        return DB::table(self::table)->max('School_Year');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ModuleClass extends Model
{
    public const table = 'module_class';
    public const table_as = 'module_class as mc';

    public function getModuleClasses1 ($first_school_year, $second_school_year): Collection
    {
        $this->_createTemporaryTable($first_school_year, $second_school_year);

        return DB::table(self::table_as)
            ->join('temp as t', 'mc.school_year', '=', 't.school_year')
            ->orderBy('id_module_class')
            ->select('id_module_class', 'module_class_name')
            ->get();
    }

    public function getModuleClasses2 ($module_class_list): array
    {
        return DB::table(self::table_as)
            ->whereIn('id_module_class',$module_class_list)
            ->pluck('id_module_class')
            ->toArray();
    }

    private function _createTemporaryTable ($first_school_year, $second_school_year)
    {
        $sql_query =
            'CREATE TEMPORARY TABLE temp(
                     school_year varchar(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE = InnoDB default CHARSET = utf8 COLLATE = utf8_unicode_ci';

        DB::unprepared($sql_query);

        DB::table('temp')
            ->insert([
                ['school_year' => $first_school_year],
                ['school_year' => $second_school_year]
            ]);
    }

    public function getLatestSchoolYear ()
    {
        return DB::table(self::table)->max('school_year');
    }
}

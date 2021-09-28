<?php

namespace App\Depositories;

use App\Models\ModuleClass;
use Illuminate\Support\Collection;

class ModuleClassDepository implements Contracts\ModuleClassDepositoryContract
{
    private ModuleClass $model;

    /**
     * ModuleClassDepository constructor.
     * @param ModuleClass $model
     */
    public function __construct (ModuleClass $model)
    {
        $this->model = $model;
    }

    public function getLatestSchoolYear ()
    {
        return ModuleClass::max('school_year');
    }

    public function getModuleClasses1 ($first_school_year, $second_school_year) : Collection
    {
        return ModuleClass::whereIn('school_year', [$first_school_year, $second_school_year])
                          ->orderBy('id_module_class')
                          ->select('id_module_class', 'module_class_name')
                          ->get();
    }

    public function getModuleClasses2 ($module_class_list) : array
    {
        return ModuleClass::whereIn('id_module_class', $module_class_list)
                          ->pluck('id_module_class')
                          ->toArray();
    }
}

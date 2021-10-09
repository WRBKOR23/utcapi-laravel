<?php

namespace App\Repositories;

use App\Models\ModuleClass;
use App\Repositories\Contracts\ModuleClassRepositoryContract;
use Illuminate\Support\Collection;

class ModuleClassRepository implements ModuleClassRepositoryContract
{
    public function getLatestSchoolYear ()
    {
        return ModuleClass::max('id_school_year');
    }

    public function getModuleClasses1 ($id_school_year_list) : Collection
    {
        return ModuleClass::whereIn('id_school_year', $id_school_year_list)
                          ->orderBy('id')
                          ->select('id as id_module_class', 'module_class_name')
                          ->get();
    }

    public function getModuleClasses2 ($module_class_list) : array
    {
        return ModuleClass::whereIn('id', $module_class_list)
                          ->pluck('id')
                          ->toArray();
    }
}

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
        return $this->model->getLatestSchoolYear();
    }

    public function getModuleClasses1 ($first_school_year, $second_school_year): Collection
    {
        return $this->model->getModuleClasses1($first_school_year, $second_school_year);
    }

    public function getModuleClasses2 ($module_class_list): array
    {
        return $this->model->getModuleClasses2($module_class_list);
    }
}

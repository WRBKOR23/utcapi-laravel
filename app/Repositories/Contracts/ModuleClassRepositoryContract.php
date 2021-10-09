<?php

namespace App\Repositories\Contracts;

interface ModuleClassRepositoryContract
{
    public function getLatestSchoolYear ();

    public function getModuleClasses1 ($id_school_year_list);

    public function getModuleClasses2 ($module_class_list);
}

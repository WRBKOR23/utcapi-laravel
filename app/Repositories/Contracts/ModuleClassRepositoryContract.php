<?php

namespace App\Repositories\Contracts;

interface ModuleClassRepositoryContract
{
    public function getLatestSchoolYear ();

    public function getModuleClasses1 ($first_school_year, $second_school_year);

    public function getModuleClasses2 ($module_class_list);
}

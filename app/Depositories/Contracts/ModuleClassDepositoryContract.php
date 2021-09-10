<?php

namespace App\Depositories\Contracts;

interface ModuleClassDepositoryContract
{
    public function getLatestSchoolYear ();

    public function getModuleClasses1 ($first_school_year, $second_school_year);

    public function getModuleClasses2 ($module_class_list);
}

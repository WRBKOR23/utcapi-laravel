<?php

namespace App\Depositories\Contracts;

interface ModuleClassDepositoryContract
{
    public function getLatestSchoolYear ();

    public function getModuleClasses ($first_school_year, $second_school_year);
}

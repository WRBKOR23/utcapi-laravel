<?php

namespace App\Services;

use App\Repositories\Contracts\ModuleClassRepositoryContract;
use App\Services\Contracts\ModuleClassServiceContract;

class ModuleClassService implements ModuleClassServiceContract
{
    private ModuleClassRepositoryContract $moduleClassDepository;

    /**
     * ModuleClassService constructor.
     * @param ModuleClassRepositoryContract $moduleClassDepository
     */
    public function __construct (ModuleClassRepositoryContract $moduleClassDepository)
    {
        $this->moduleClassDepository = $moduleClassDepository;
    }

    public function getModuleClasses ()
    {
        $id_school_year_list = $this->_getSchoolYears();
        return $this->moduleClassDepository->getModuleClasses1($id_school_year_list);
    }

    private function _getSchoolYears () : array
    {
        $latest_school_year = $this->moduleClassDepository->getLatestSchoolYear();
        return [intval($latest_school_year) - 1, intval($latest_school_year)];
    }
}

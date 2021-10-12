<?php

namespace App\Services;

use App\Repositories\Contracts\ModuleClassRepositoryContract;
use App\Services\Contracts\ModuleClassServiceContract;

class ModuleClassService implements ModuleClassServiceContract
{
    private ModuleClassRepositoryContract $moduleClassRepository;

    /**
     * ModuleClassService constructor.
     * @param ModuleClassRepositoryContract $moduleClassRepository
     */
    public function __construct (ModuleClassRepositoryContract $moduleClassRepository)
    {
        $this->moduleClassRepository = $moduleClassRepository;
    }

    public function getModuleClasses ()
    {
        $id_school_year_list = $this->_getSchoolYears();
        return $this->moduleClassRepository->getModuleClasses1($id_school_year_list);
    }

    private function _getSchoolYears () : array
    {
        $latest_school_year = $this->moduleClassRepository->getLatestSchoolYear();
        return [intval($latest_school_year) - 1, intval($latest_school_year)];
    }
}

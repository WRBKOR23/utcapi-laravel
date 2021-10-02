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
        $school_year_list = $this->_getSchoolYears();
        return $this->moduleClassDepository->getModuleClasses1($school_year_list[0], $school_year_list[1]);
    }

    private function _getSchoolYears (): array
    {
        $latest_school_year = $this->moduleClassDepository->getLatestSchoolYear();

        $first_school_year  = '';
        $second_school_year = '';

        switch (intval(substr($latest_school_year, 0, 1)))
        {
            case 1:
                $first_school_year  = '2' . '-' . (intval(substr($latest_school_year, 2, 2)) - 1);
                $second_school_year = $latest_school_year;
                break;

            case 2:
                $first_school_year  = '1' . '-' . substr($latest_school_year, 2, 2);
                $second_school_year = $latest_school_year;
        }

        return [$first_school_year, $second_school_year];
    }
}

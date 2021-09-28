<?php

namespace App\Services;

use App\Depositories\Contracts\ClassDepositoryContract;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\FacultyClassServiceContract;

class FacultyClassService implements FacultyClassServiceContract
{
    private ClassDepositoryContract $classDepository;

    /**
     * FacultyClassService constructor.
     * @param ClassDepositoryContract $classDepository
     */
    public function __construct (ClassDepositoryContract $classDepository)
    {
        $this->classDepository = $classDepository;
    }

    public function getFacultyClassesAndAcademicYears () : array
    {
        $academic_year_list = $this->_getAcademicYears();
        $faculty_class_list = $this->_getFacultyClasses(SharedFunctions::formatArray($academic_year_list, 'academic_year'));

        return [$academic_year_list, $faculty_class_list];
    }

    private function _getAcademicYears()
    {
        return $this->classDepository->getAcademicYears();
    }

    private function _getFacultyClasses($academic_year_list)
    {
        return $this->classDepository->getFacultyClass($academic_year_list);
    }
}

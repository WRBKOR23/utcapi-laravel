<?php

namespace App\Services;

use App\Repositories\Contracts\ClassRepositoryContract;
use App\Helpers\SharedFunctions;
use App\Services\Contracts\FacultyClassServiceContract;

class FacultyClassService implements FacultyClassServiceContract
{
    private ClassRepositoryContract $classRepository;

    /**
     * FacultyClassService constructor.
     * @param ClassRepositoryContract $classRepository
     */
    public function __construct (ClassRepositoryContract $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    public function getFacultyClassesAndAcademicYears () : array
    {
        $academic_year_list = $this->_getAcademicYears();
        $faculty_class_list = $this->_getFacultyClasses(SharedFunctions::formatArray($academic_year_list, 'academic_year'));

        return [$academic_year_list, $faculty_class_list];
    }

    private function _getAcademicYears()
    {
        return $this->classRepository->getAcademicYears();
    }

    private function _getFacultyClasses($academic_year_list)
    {
        return $this->classRepository->getFacultyClass($academic_year_list);
    }
}

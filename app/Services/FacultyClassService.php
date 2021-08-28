<?php

namespace App\Services;

use App\Depositories\Contracts\ClassDepositoryContract;
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

    public function getFacultyClassesAndAcademicYears (): array
    {
        $academic_year_list = $this->classDepository->getAcademicYears();
        $faculty_class_list = $this->classDepository->getFacultyClass($academic_year_list);

        return [$academic_year_list, $faculty_class_list];
    }
}

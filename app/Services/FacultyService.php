<?php

namespace App\Services;

use App\Depositories\Contracts\FacultyDepositoryContract;
use App\Helpers\SharedData;

class FacultyService implements Contracts\FacultyServiceContract
{
    private FacultyDepositoryContract $facultyDepository;

    /**
     * @param FacultyDepositoryContract $facultyDepository
     */
    public function __construct (FacultyDepositoryContract $facultyDepository)
    {
        $this->facultyDepository = $facultyDepository;
    }

    public function getInfoFaculties ()
    {
        return $this->facultyDepository->getAll(SharedData::$id_faculties);
    }
}
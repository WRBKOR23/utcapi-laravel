<?php

namespace App\Services;

use App\Repositories\Contracts\FacultyRepositoryContract;
use App\Helpers\SharedData;

class FacultyService implements Contracts\FacultyServiceContract
{
    private FacultyRepositoryContract $facultyRepository;

    /**
     * @param FacultyRepositoryContract $facultyRepository
     */
    public function __construct (FacultyRepositoryContract $facultyRepository)
    {
        $this->facultyRepository = $facultyRepository;
    }

    public function getFaculties ()
    {
        return $this->facultyRepository->getAll(SharedData::$id_faculties);
    }
}
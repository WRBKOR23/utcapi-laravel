<?php

namespace App\Services;


use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Services\Contracts\DataVersionStudentServiceContract;

class DataVersionStudentService implements DataVersionStudentServiceContract
{
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;

    /**
     * DataVersionStudentService constructor.
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     */
    public function __construct (DataVersionStudentRepositoryContract $dataVersionStudentRepository)
    {
        $this->dataVersionStudentRepository = $dataVersionStudentRepository;
    }

    public function getDataVersion ($id_student)
    {
        return $this->dataVersionStudentRepository->get($id_student);
    }
}

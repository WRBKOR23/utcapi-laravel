<?php

namespace App\Services;

use App\Repositories\Contracts\DataVersionStudentRepositoryContract;

class DataVersionStudentService implements Contracts\DataVersionStudentServiceContract
{
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;

    /**
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

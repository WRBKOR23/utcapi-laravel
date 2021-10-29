<?php

namespace App\Services;

use App\Repositories\Contracts\DataVersionTeacherRepositoryContract;

class DataVersionTeacherService implements Contracts\DataVersionTeacherServiceContract
{
    private DataVersionTeacherRepositoryContract $dataVersionTeacherRepository;

    /**
     * @param DataVersionTeacherRepositoryContract $dataVersionTeacherRepository
     */
    public function __construct (DataVersionTeacherRepositoryContract $dataVersionTeacherRepository)
    {
        $this->dataVersionTeacherRepository = $dataVersionTeacherRepository;
    }

    public function getDataVersion ($id_teacher)
    {
        return $this->dataVersionTeacherRepository->get($id_teacher);
    }
}

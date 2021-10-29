<?php

namespace App\Services;

use App\Repositories\Contracts\ModuleScoreRepositoryContract;

class ModuleScoreService implements Contracts\ModuleScoreServiceContract
{
    private ModuleScoreRepositoryContract $moduleScoreRepository;

    /**
     * @param ModuleScoreRepositoryContract $moduleScoreRepository
     */
    public function __construct (ModuleScoreRepositoryContract $moduleScoreRepository)
    {
        $this->moduleScoreRepository = $moduleScoreRepository;
    }

    public function get ($id_student)
    {
        return $this->moduleScoreRepository->get($id_student);
    }
}

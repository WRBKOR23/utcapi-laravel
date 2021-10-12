<?php


namespace App\Services;


use App\Repositories\Contracts\ModuleScoreRepositoryContract;
use App\Services\Contracts\ModuleScoreServiceContract;

class ModuleScoreService implements ModuleScoreServiceContract
{
    private ModuleScoreRepositoryContract $moduleScoreRepository;

    /**
     * ModuleScoreService constructor.
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

<?php

namespace App\Http\Controllers\ApiController;

use App\Services\Contracts\ModuleScoreServiceContract;

class ModuleScoreController
{
    private ModuleScoreServiceContract $moduleScoreService;

    /**
     * ModuleScoreController constructor.
     * @param ModuleScoreServiceContract $moduleScoreService
     */
    public function __construct (ModuleScoreServiceContract $moduleScoreService)
    {
        $this->moduleScoreService = $moduleScoreService;
    }

    public function get ($id_student)
    {
        return $this->moduleScoreService->get($id_student);
    }
}

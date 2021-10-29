<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ModuleScoreServiceContract;

class ModuleScoreController
{
    private ModuleScoreServiceContract $moduleScoreService;

    /**
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

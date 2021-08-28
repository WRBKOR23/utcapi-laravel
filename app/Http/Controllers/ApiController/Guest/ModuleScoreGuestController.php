<?php

namespace App\Http\Controllers\ApiController\Guest;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\ModuleScoreGuestServiceContract;

class ModuleScoreGuestController extends Controller
{
    private ModuleScoreGuestServiceContract $moduleScoreGuestService;

    /**
     * ModuleScoreGuestController constructor.
     * @param ModuleScoreGuestServiceContract $moduleScoreGuestService
     */
    public function __construct (ModuleScoreGuestServiceContract $moduleScoreGuestService)
    {
        $this->moduleScoreGuestService = $moduleScoreGuestService;
    }

    public function get ($id_student)
    {
        return $this->moduleScoreGuestService->get($id_student);
    }
}

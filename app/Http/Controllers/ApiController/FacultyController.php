<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Services\Contracts\FacultyServiceContract;

class FacultyController extends Controller
{
    private FacultyServiceContract $facultyService;

    /**
     * FacultyController constructor.
     * @param FacultyServiceContract $facultyService
     */
    public function __construct (FacultyServiceContract $facultyService)
    {
        $this->facultyService = $facultyService;
    }

    public function getInfoFaculties ()
    {
        return response($this->facultyService->getInfoFaculties());
    }
}
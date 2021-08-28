<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Services\Contracts\FacultyClassServiceContract;

class FacultyClassController extends Controller
{
    private FacultyClassServiceContract $facultyClassService;

    /**
     * FacultyClassController constructor.
     * @param FacultyClassServiceContract $facultyClassService
     */
    public function __construct (FacultyClassServiceContract $facultyClassService)
    {
        $this->facultyClassService = $facultyClassService;
    }

    public function getFacultyClassesAndAcademicYears ()
    {
        return response($this->facultyClassService->getFacultyClassesAndAcademicYears())
            ->header('Content-Type', 'application/json');
    }
}

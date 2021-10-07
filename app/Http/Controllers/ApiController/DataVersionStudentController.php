<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Services\Contracts\DataVersionStudentServiceContract;

class DataVersionStudentController extends Controller
{
    private DataVersionStudentServiceContract $dataVersionStudentService;

    public function __construct (DataVersionStudentServiceContract $dataVersionStudentService)
    {
        $this->dataVersionStudentService = $dataVersionStudentService;
    }

    public function getDataVersion ($id_student)
    {
        return $this->dataVersionStudentService->getDataVersion($id_student);
    }
}

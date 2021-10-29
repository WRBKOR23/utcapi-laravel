<?php

namespace App\Http\Controllers;

use App\Services\Contracts\DataVersionTeacherServiceContract;

class DataVersionTeacherController extends Controller
{
    private DataVersionTeacherServiceContract $dataVersionTeacherService;

    /**
     * @param DataVersionTeacherServiceContract $dataVersionTeacherService
     */
    public function __construct (DataVersionTeacherServiceContract $dataVersionTeacherService)
    {
        $this->dataVersionTeacherService = $dataVersionTeacherService;
    }

    public function getDataVersion ($id_teacher)
    {
        return $this->dataVersionTeacherService->getDataVersion($id_teacher);
    }
}

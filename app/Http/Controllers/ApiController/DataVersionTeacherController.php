<?php


namespace App\Http\Controllers\ApiController;


use App\Http\Controllers\Controller;
use App\Services\Contracts\DataVersionTeacherServiceContract;

class DataVersionTeacherController extends Controller
{
    private DataVersionTeacherServiceContract $dataVersionTeacherService;

    /**
     * DataVersionTeacherController constructor.
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

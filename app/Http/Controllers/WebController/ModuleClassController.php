<?php

namespace App\Http\Controllers\WebController;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ModuleClassServiceContract;

class ModuleClassController extends Controller
{
    private ModuleClassServiceContract $moduleClassService;

    /**
     * ModuleClassController constructor.
     * @param ModuleClassServiceContract $moduleClassService
     */
    public function __construct (ModuleClassServiceContract $moduleClassService)
    {
        $this->moduleClassService = $moduleClassService;
    }


    public function getModuleClasses ()
    {
        $module_class_list = $this->moduleClassService->getModuleClasses();

        return response($module_class_list)
            ->header('Content-Type', 'application/data');
    }
}

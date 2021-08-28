<?php

namespace App\Http\Controllers\WebController;

use App\BusinessClass\FileUploadHandle;
use App\Http\Controllers\Controller;
use App\Services\Contracts\AccountServiceContract;
use App\Services\Contracts\dataServiceContract;
use App\Services\dataService;
use Exception;
use Illuminate\Http\Request;

class DataController extends Controller
{
    private dataServiceContract $dataService;

    /**
     * ImportDataController constructor.
     * @param dataServiceContract $dataService
     */
    public function __construct (dataServiceContract $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * @throws Exception
     */
    public function process1 (Request $request)
    {
        $data = $this->dataService->process1($request->file);

        if (!empty($data[1]))
        {
            return response($data, 201);
        }

        return response($data);
    }

    public function process2 (Request $request)
    {
        $this->dataService->process2($request->all());

        return response('OK');
    }
}

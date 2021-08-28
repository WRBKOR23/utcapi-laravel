<?php


namespace App\Http\Controllers\ApiController\Guest;


use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\DataVersionGuestServiceContract;

class DataVersionGuestController extends Controller
{
    private DataVersionGuestServiceContract $dataVersionGuestService;

    /**
     * DataVersionGuestController constructor.
     * @param DataVersionGuestServiceContract $dataVersionGuestService
     */
    public function __construct (DataVersionGuestServiceContract $dataVersionGuestService)
    {
        $this->dataVersionGuestService = $dataVersionGuestService;
    }

    public function getDataVersion($id_student)
    {
        return $this->dataVersionGuestService->getDataVersion($id_student);
    }

    public function getNotificationVersion($id_student)
    {
        return $this->dataVersionGuestService->getNotificationVersion($id_student);
    }
}

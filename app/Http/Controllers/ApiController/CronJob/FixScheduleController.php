<?php


namespace App\Http\Controllers\ApiController\CronJob;


use App\Services\Contracts\FixScheduleServiceContract;

class FixScheduleController
{
    private FixScheduleServiceContract $fixScheduleService;

    /**
     * FixScheduleController constructor.
     * @param FixScheduleServiceContract $fixScheduleService
     */
    public function __construct (FixScheduleServiceContract $fixScheduleService)
    {
        $this->fixScheduleService = $fixScheduleService;
    }

    public function checkFixSchedule ()
    {
        $this->fixScheduleService->sendNotificationOfFixSchedules();
    }
}

<?php

    namespace App\Http\Controllers\ApiController;

    use App\Http\Controllers\Controller;
    use App\Services\Contracts\ExamScheduleServiceContract;

    class ExamScheduleController extends Controller
    {
        private ExamScheduleServiceContract $examScheduleService;

        /**
         * ExamScheduleController constructor.
         * @param ExamScheduleServiceContract $examScheduleService
         */
        public function __construct (ExamScheduleServiceContract $examScheduleService)
        {
            $this->examScheduleService = $examScheduleService;
        }

        public function get ($id_student)
        {
            return $this->examScheduleService->get($id_student);
        }

    }

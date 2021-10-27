<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFormRequestException;
use App\Http\FormRequest\CrawlForm;
use App\Services\Contracts\CrawlExamScheduleServiceContract;
use Illuminate\Http\Request;

class CrawlExamScheduleController extends Controller
{
    private CrawlForm $form;
    private CrawlExamScheduleServiceContract $crawlExamScheduleService;

    /**
     * CrawlExamScheduleController constructor.
     * @param CrawlForm $form
     * @param CrawlExamScheduleServiceContract $crawlExamScheduleService
     */
    public function __construct (CrawlForm $form, CrawlExamScheduleServiceContract $crawlExamScheduleService)
    {
        $this->form                     = $form;
        $this->crawlExamScheduleService = $crawlExamScheduleService;
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function crawlAll (Request $request)
    {
        $this->form->validate($request);
        $this->crawlExamScheduleService->crawlAll($request->id_student);
        return response('OK');
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function crawl (Request $request)
    {
        $this->form->validate($request);
        $this->crawlExamScheduleService->crawl($request->id_student);
        return response('OK');
    }

}

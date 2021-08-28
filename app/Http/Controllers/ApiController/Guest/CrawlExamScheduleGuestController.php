<?php

namespace App\Http\Controllers\ApiController\Guest;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\CrawlExamScheduleGuestServiceContract;
use Illuminate\Http\Request;

class CrawlExamScheduleGuestController extends Controller
{
    private CrawlExamScheduleGuestServiceContract $crawlExamScheduleGuestService;

    /**
     * CrawlExamScheduleGuestController constructor.
     * @param CrawlExamScheduleGuestServiceContract $crawlExamScheduleGuestService
     */
    public function __construct (CrawlExamScheduleGuestServiceContract $crawlExamScheduleGuestService)
    {
        $this->crawlExamScheduleGuestService = $crawlExamScheduleGuestService;
    }

    public function crawlAll (Request $request)
    {
        if (!$this->crawlExamScheduleGuestService->crawlAll($request->id_student))
        {
            return response('Invalid Password', 401);
        }

        return response('OK');
    }

    public function crawl (Request $request)
    {
        if (!$this->crawlExamScheduleGuestService->crawl($request->id_student))
        {
            return response('Invalid Password', 401);
        }

        return response('OK');
    }
}

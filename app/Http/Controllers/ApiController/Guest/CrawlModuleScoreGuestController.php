<?php

namespace App\Http\Controllers\ApiController\Guest;

use App\Http\Controllers\Controller;
use App\Services\Contracts\Guest\CrawlModuleScoreGuestServiceContract;
use Illuminate\Http\Request;

class CrawlModuleScoreGuestController extends Controller
{
    private CrawlModuleScoreGuestServiceContract $crawlModuleScoreGuestService;

    /**
     * CrawlModuleScoreGuestController constructor.
     * @param CrawlModuleScoreGuestServiceContract $crawlModuleScoreGuestService
     */
    public function __construct (CrawlModuleScoreGuestServiceContract $crawlModuleScoreGuestService)
    {
        $this->crawlModuleScoreGuestService = $crawlModuleScoreGuestService;
    }

    public function crawlAll (Request $request)
    {
        if (!$this->crawlModuleScoreGuestService->crawlAll($request->id_student)) {
            return response('Invalid Password', 401);
        }

        return response('OK');
    }

    public function crawl (Request $request)
    {
        if (!$this->crawlModuleScoreGuestService->crawl($request->id_student)) {
            return response('Invalid Password', 401);
        }

        return response('OK');
    }
}

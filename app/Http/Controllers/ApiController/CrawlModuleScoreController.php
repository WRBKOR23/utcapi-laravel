<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Services\Contracts\CrawlModuleScoreServiceContract;
use Illuminate\Http\Request;

class CrawlModuleScoreController extends Controller
{
    private CrawlModuleScoreServiceContract $crawlModuleScoreService;

    /**
     * CrawlModuleScoreController constructor.
     * @param CrawlModuleScoreServiceContract $crawlModuleScoreService
     */
    public function __construct (CrawlModuleScoreServiceContract $crawlModuleScoreService)
    {
        $this->crawlModuleScoreService = $crawlModuleScoreService;
    }

    public function crawlAll (Request $request)
    {
        $this->crawlModuleScoreService->crawlAll($request->id_student);
        return response('OK');
    }

    public function crawl (Request $request)
    {
        $this->crawlModuleScoreService->crawl($request->id_student);
        return response('OK');
    }
}

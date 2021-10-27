<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFormRequestException;
use App\Http\FormRequest\CrawlForm;
use App\Services\Contracts\CrawlModuleScoreServiceContract;
use Illuminate\Http\Request;

class CrawlModuleScoreController extends Controller
{
    private CrawlForm $form;
    private CrawlModuleScoreServiceContract $crawlModuleScoreService;

    /**
     * @param CrawlForm $form
     * @param CrawlModuleScoreServiceContract $crawlModuleScoreService
     */
    public function __construct (CrawlForm $form, CrawlModuleScoreServiceContract $crawlModuleScoreService)
    {
        $this->form                    = $form;
        $this->crawlModuleScoreService = $crawlModuleScoreService;
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function crawlAll (Request $request)
    {
        $this->form->validate($request);
        $this->crawlModuleScoreService->crawlAll($request->id_student);
        return response('OK');
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function crawl (Request $request)
    {
        $this->form->validate($request);
        $this->crawlModuleScoreService->crawl($request->id_student);
        return response('OK');
    }
}

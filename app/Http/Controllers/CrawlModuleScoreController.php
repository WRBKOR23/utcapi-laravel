<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFormRequestException;
use App\Http\FormRequest\CrawlForm;
use App\Services\Contracts\CrawlServiceContract;
use Illuminate\Http\Request;

class CrawlModuleScoreController extends Controller
{
    private CrawlForm $form;
    private CrawlServiceContract $crawlServiceContract;

    /**
     * @param CrawlForm            $form
     * @param CrawlServiceContract $crawlServiceContract
     */
    public function __construct (CrawlForm $form, CrawlServiceContract $crawlServiceContract)
    {
        $this->form                 = $form;
        $this->crawlServiceContract = $crawlServiceContract;
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function crawlAll (Request $request)
    {
        $this->form->validate($request);
        $this->crawlServiceContract->crawlAll($request->id_account, $request->id_student);
        return response('OK');
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function crawl (Request $request)
    {
        $this->form->validate($request);
        $this->crawlServiceContract->crawl($request->id_account, $request->id_student);
        return response('OK');
    }
}

<?php

namespace App\Services\AbstractClasses;

use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Services\Contracts\CrawlServiceContract;
use Exception;
use Illuminate\Support\Facades\Cache;

abstract class ACrawlService implements CrawlServiceContract
{
    protected CrawlQLDTData $crawl;
    protected AccountRepositoryContract $accountRepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;
    protected array $terms;

    /**
     * @param CrawlQLDTData                        $crawl
     * @param AccountRepositoryContract            $accountRepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 AccountRepositoryContract            $accountRepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentRepository)
    {
        $this->crawl                        = $crawl;
        $this->accountRepository            = $accountRepository;
        $this->dataVersionStudentRepository = $dataVersionStudentRepository;
        $this->_getRecentTerms();
    }

    /**
     * @param $id_account *
     *
     * @throws Exception
     */
    public function crawl ($id_account, $id_student)
    {
        $this->_loginQLDT($id_account, $id_student);
    }

    /**
     * @param $id_account *
     *
     * @throws Exception
     */
    public function crawlAll ($id_account, $id_student)
    {
        $this->_loginQLDT($id_account, $id_student);
    }

    /**
     * @throws Exception
     */
    public function crawlByTerm ($id_student, $term)
    {
        $this->_loginQLDT($id_student, $id_student);
    }

    /**
     * @param $id_account *
     *
     * @throws Exception
     */
    private function _loginQLDT ($id_account, $id_student)
    {
        $qldt_password = $this->_getQLDTPassword($id_account);
        $this->crawl->loginQLDT($id_student, $qldt_password);
    }

    private function _getQLDTPassword ($id_account) : string
    {
        return $this->accountRepository->getQLDTPassword($id_account);
    }

    private function _getRecentTerms ()
    {
        $this->terms = Cache::get('school_years') ?? Cache::get('school_years_backup');
    }

    protected function _insertMultiple ($data)
    {
        $arr = [];
        foreach ($data as $term)
        {
            foreach ($term as $module)
            {
                $module['id_term'] = $this->terms[$module['term']];
                unset($module['term']);
                $arr[] = $module;
            }
        }
        $this->_customInsertMultiple($arr);
    }

    protected function _upsert ($data)
    {
        foreach ($data as $term)
        {
            foreach ($term as $module)
            {
                $module['id_term'] = $this->terms[$module['term']];
                unset($module['term']);
                $this->_customUpsert($module);
            }
        }
    }

    protected function _updateDataVersion ($id_student, $column_name)
    {
        $this->dataVersionStudentRepository->updateDataVersion($id_student, $column_name);
    }

    protected function _customInsertMultiple ($data)
    {
    }

    protected function _customUpsert ($data)
    {
    }
}

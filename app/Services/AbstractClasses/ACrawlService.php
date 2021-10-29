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
    protected array $school_years;

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
        $this->_getRecentSchoolYears();
    }

    /**
     * @throws Exception
     */
    public function crawl ($id_student)
    {
        $this->_loginQLDT($id_student);
    }

    /**
     * @throws Exception
     */
    public function crawlAll ($id_student)
    {
        $this->_loginQLDT($id_student);
    }

    /**
     * @throws Exception
     */
    public function crawlBySchoolYear ($id_student, $school_year)
    {
        $this->_loginQLDT($id_student);
    }

    /**
     * @throws Exception
     */
    private function _loginQLDT ($id_student)
    {
        $qldt_password = $this->_getQLDTPassword($id_student);
        $this->crawl->loginQLDT($id_student, $qldt_password);
    }

    private function _getQLDTPassword ($id_student) : string
    {
        return $this->accountRepository->getQLDTPassword($id_student);
    }

    private function _getRecentSchoolYears ()
    {
        $this->school_years = Cache::get('school_years') ?? Cache::get('school_years_backup');
    }

    protected function _insertMultiple ($data)
    {
        $arr = [];
        foreach ($data as $school_year)
        {
            foreach ($school_year as $module)
            {
                $module['id_school_year'] = $this->school_years[$module['school_year']];
                unset($module['school_year']);
                $arr[] = $module;
            }
        }
        $this->_customInsertMultiple($arr);
    }

    protected function _upsert ($data)
    {
        foreach ($data as $school_year)
        {
            foreach ($school_year as $module)
            {
                $module['id_school_year'] = $this->school_years[$module['school_year']];
                unset($module['school_year']);
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

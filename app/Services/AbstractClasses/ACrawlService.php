<?php

namespace App\Services\AbstractClasses;

use App\BusinessClass\CrawlQLDTData;
use App\Services\Contracts\CrawlExamScheduleServiceContract;
use App\Services\Contracts\CrawlModuleScoreServiceContract;
use App\Services\Contracts\Guest\CrawlExamScheduleGuestServiceContract;
use App\Services\Contracts\Guest\CrawlModuleScoreGuestServiceContract;
use Exception;

abstract class ACrawlService implements CrawlModuleScoreServiceContract,
                                        CrawlExamScheduleServiceContract,
                                        CrawlModuleScoreGuestServiceContract,
                                        CrawlExamScheduleGuestServiceContract
{
    protected CrawlQLDTData $crawl;

    /**
     * CrawlModuleScoreService constructor.
     * @param CrawlQLDTData $crawl
     */
    public function __construct (CrawlQLDTData $crawl)
    {
        $this->crawl = $crawl;
    }

    /**
     * @throws Exception
     */
    public function crawl ($id_student)
    {
        $this->_verifyAccount($id_student);
    }

    /**
     * @throws Exception
     */
    public function crawlAll ($id_student)
    {
        $this->_verifyAccount($id_student);
    }

    /**
     * @throws Exception
     */
    private function _verifyAccount ($id_student)
    {
        $qldt_password = $this->_getQLDTPassword($id_student);
        $this->_loginQLDT($id_student, $qldt_password);
    }

    protected function _getQLDTPassword ($id_student): string
    {
        return '';
    }

    /**
     * @throws Exception
     */
    private function _loginQLDT ($id_student, $password): void
    {
        $this->crawl->loginQLDT($id_student, $password);
    }

    protected function _insertMultiple ($data)
    {
        $arr = [];
        foreach ($data as $school_year)
        {
            foreach ($school_year as $module)
            {
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
                $this->_customUpsert($module);
            }
        }
    }

    protected function _customInsertMultiple ($data)
    {
    }

    protected function _customUpsert ($data)
    {
    }

    protected function _updateDataVersion ($id_student)
    {
    }
}

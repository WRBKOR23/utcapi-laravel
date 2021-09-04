<?php

namespace App\Services;

use App\BusinessClass\CrawlQLDTData;
use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Depositories\Contracts\ModuleScoreDepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlModuleScoreService extends ACrawlService
{
    private AccountDepositoryContract $accountDepository;
    private ModuleScoreDepositoryContract $moduleScoreDepository;
    private DataVersionStudentDepositoryContract $dataVersionStudentDepository;

    /**
     * CrawlModuleScoreService constructor.
     * @param CrawlQLDTData $crawl
     * @param AccountDepositoryContract $accountDepository
     * @param ModuleScoreDepositoryContract $moduleScoreDepository
     * @param DataVersionStudentDepositoryContract $dataVersionStudentDepository
     */
    public function __construct (CrawlQLDTData $crawl,
                                 AccountDepositoryContract $accountDepository,
                                 ModuleScoreDepositoryContract $moduleScoreDepository,
                                 DataVersionStudentDepositoryContract $dataVersionStudentDepository)
    {
        parent::__construct($crawl);
        $this->accountDepository            = $accountDepository;
        $this->moduleScoreDepository        = $moduleScoreDepository;
        $this->dataVersionStudentDepository = $dataVersionStudentDepository;
    }

    public function crawlAll ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentModuleScore(true);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student);
    }

    public function crawl ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentModuleScore(false);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student);
    }

    protected function _getQLDTPassword ($id_student): string
    {
        return $this->accountDepository->getQLDTPassword($id_student);
    }

    protected function _updateDataVersion ($id_student)
    {
        $this->dataVersionStudentDepository->updateDataVersion($id_student, 'module_score');
    }

    protected function _customInsertMultiple ($data)
    {
        $this->moduleScoreDepository->insertMultiple($data);
    }

    protected function _customUpsert ($data)
    {
        $this->moduleScoreDepository->upsert($data);
    }
}

<?php

namespace App\Services;

use App\BusinessClass\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\ModuleScoreDepositoryContract;
use App\Repositories\Contracts\SchoolYearRepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlModuleScoreService extends ACrawlService
{
    private ModuleScoreDepositoryContract $moduleScoreDepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentDepository;

    /**
     * @param CrawlQLDTData $crawl
     * @param AccountRepositoryContract $accountDepository
     * @param SchoolYearRepositoryContract $schoolYearRepository
     * @param ModuleScoreDepositoryContract $moduleScoreDepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentDepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 AccountRepositoryContract            $accountDepository,
                                 SchoolYearRepositoryContract         $schoolYearRepository,
                                 ModuleScoreDepositoryContract        $moduleScoreDepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentDepository)
    {
        parent::__construct($crawl, $accountDepository, $schoolYearRepository);
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

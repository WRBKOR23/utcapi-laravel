<?php

namespace App\Services;

use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\ModuleScoreRepositoryContract;
use App\Repositories\Contracts\SchoolYearRepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlModuleScoreService extends ACrawlService
{
    private ModuleScoreRepositoryContract $moduleScoreRepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentRepository;

    /**
     * @param CrawlQLDTData $crawl
     * @param AccountRepositoryContract $accountRepository
     * @param SchoolYearRepositoryContract $schoolYearRepository
     * @param ModuleScoreRepositoryContract $moduleScoreRepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 AccountRepositoryContract            $accountRepository,
                                 SchoolYearRepositoryContract         $schoolYearRepository,
                                 ModuleScoreRepositoryContract        $moduleScoreRepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentRepository)
    {
        parent::__construct($crawl, $accountRepository, $schoolYearRepository);
        $this->moduleScoreRepository        = $moduleScoreRepository;
        $this->dataVersionStudentRepository = $dataVersionStudentRepository;
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
        $this->dataVersionStudentRepository->updateDataVersion($id_student, 'module_score');
    }

    protected function _customInsertMultiple ($data)
    {
        $this->moduleScoreRepository->insertMultiple($data);
    }

    protected function _customUpsert ($data)
    {
        $this->moduleScoreRepository->upsert($data);
    }
}

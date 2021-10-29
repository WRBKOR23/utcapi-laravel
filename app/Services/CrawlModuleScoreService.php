<?php

namespace App\Services;

use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\ModuleScoreRepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlModuleScoreService extends ACrawlService
{
    private ModuleScoreRepositoryContract $moduleScoreRepository;

    /**
     * @param CrawlQLDTData                        $crawl
     * @param AccountRepositoryContract            $accountRepository
     * @param ModuleScoreRepositoryContract        $moduleScoreRepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 AccountRepositoryContract            $accountRepository,
                                 ModuleScoreRepositoryContract        $moduleScoreRepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentRepository)
    {
        parent::__construct($crawl, $accountRepository, $dataVersionStudentRepository);
        $this->moduleScoreRepository = $moduleScoreRepository;
    }

    public function crawlAll ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentModuleScore('all');
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student, 'module_score');
    }

    public function crawl ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentModuleScore('latest');
        $this->_upsert($data);
        $this->_updateDataVersion($id_student, 'module_score');
    }

    public function crawlBySchoolYear ($id_student, $school_year)
    {
        parent::crawlBySchoolYear($id_student, $school_year);
        $data = $this->crawl->getStudentModuleScore('specific');

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

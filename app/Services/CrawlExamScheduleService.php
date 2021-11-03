<?php

namespace App\Services;

use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\ExamScheduleRepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlExamScheduleService extends ACrawlService
{
    private ExamScheduleRepositoryContract $examScheduleRepository;

    /**
     * @param CrawlQLDTData                        $crawl
     * @param AccountRepositoryContract            $accountRepository
     * @param ExamScheduleRepositoryContract       $examScheduleRepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentRepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 AccountRepositoryContract            $accountRepository,
                                 ExamScheduleRepositoryContract       $examScheduleRepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentRepository)
    {
        parent::__construct($crawl, $accountRepository, $dataVersionStudentRepository);
        $this->examScheduleRepository = $examScheduleRepository;
    }

    public function crawlAll ($id_account, $id_student)
    {
        parent::crawl($id_account, $id_student);
        $data = $this->crawl->getStudentExamSchedule('all', $this->terms);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student, 'exam_schedule');
    }

    public function crawl ($id_account, $id_student)
    {
        parent::crawl($id_account, $id_student);
        $data = $this->crawl->getStudentExamSchedule('latest', $this->terms);
        $this->_verifyOldData($data, $id_student);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student, 'exam_schedule');
    }

    private function _verifyOldData ($data, $id_student)
    {
        $latest_id_term = $this->_getLatestIDTerm($id_student);
        foreach ($data as $term => $module)
        {
            if (!is_null($latest_id_term))
            {
                if ($this->terms[$term] < $latest_id_term)
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_id_term);
                    return;
                }

                if (empty($module) &&
                    $this->terms[$term] == $latest_id_term)
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_id_term);
                    return;
                }
            }
        }
    }

    private function _getLatestIDTerm ($id_student)
    {
        return $this->examScheduleRepository->getLatestTerm($id_student);
    }

    private function _deleteWrongExamSchedules ($id_student, $id_term)
    {
        $this->examScheduleRepository->delete($id_student, $id_term);
    }


    protected function _customInsertMultiple ($data)
    {
        $this->examScheduleRepository->insertMultiple($data);
    }

    protected function _customUpsert ($data)
    {
        $this->examScheduleRepository->upsert($data);
    }
}

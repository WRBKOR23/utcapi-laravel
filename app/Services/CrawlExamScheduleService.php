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

    public function crawlAll ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentExamSchedule('all', $this->school_years);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student, 'exam_schedule');
    }

    public function crawl ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentExamSchedule('latest', $this->school_years);
        $this->_verifyOldData($data, $id_student);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student, 'exam_schedule');
    }

    private function _verifyOldData ($data, $id_student)
    {
        $latest_id_school_year = $this->_getLatestIDSchoolYear($id_student);
        foreach ($data as $school_year => $module)
        {
            if (!is_null($latest_id_school_year))
            {
                if ($this->school_years[$school_year] < $latest_id_school_year)
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_id_school_year);
                    return;
                }

                if (empty($module) &&
                    $this->school_years[$school_year] == $latest_id_school_year)
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_id_school_year);
                    return;
                }
            }
        }
    }

    private function _getLatestIDSchoolYear ($id_student)
    {
        return $this->examScheduleRepository->getLatestSchoolYear($id_student);
    }

    private function _deleteWrongExamSchedules ($id_student, $school_year)
    {
        $this->examScheduleRepository->delete($id_student, $school_year);
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

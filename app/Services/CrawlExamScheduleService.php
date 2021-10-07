<?php


namespace App\Services;


use App\BusinessClasses\CrawlQLDTData;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\ExamScheduleRepositoryContract;
use App\Repositories\Contracts\SchoolYearRepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlExamScheduleService extends ACrawlService
{
    private ExamScheduleRepositoryContract $examScheduleDepository;
    private DataVersionStudentRepositoryContract $dataVersionStudentDepository;

    /**
     * CrawlExamScheduleService constructor.
     * @param CrawlQLDTData $crawl
     * @param AccountRepositoryContract $accountDepository
     * @param SchoolYearRepositoryContract $schoolYearRepository
     * @param ExamScheduleRepositoryContract $examScheduleDepository
     * @param DataVersionStudentRepositoryContract $dataVersionStudentDepository
     */
    public function __construct (CrawlQLDTData                        $crawl,
                                 AccountRepositoryContract            $accountDepository,
                                 SchoolYearRepositoryContract         $schoolYearRepository,
                                 ExamScheduleRepositoryContract       $examScheduleDepository,
                                 DataVersionStudentRepositoryContract $dataVersionStudentDepository)
    {
        parent::__construct($crawl, $accountDepository, $schoolYearRepository);
        $this->examScheduleDepository       = $examScheduleDepository;
        $this->dataVersionStudentDepository = $dataVersionStudentDepository;
    }

    public function crawlAll ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentExamSchedule(true);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student);
    }

    public function crawl ($id_student)
    {
        parent::crawl($id_student);
        $data = $this->crawl->getStudentExamSchedule(false);
        $this->_verifyData($data);
        $this->_verifyOldData($data, $id_student);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student);
    }

    private function _verifyData (&$data)
    {
        if (count($data) == 2)
        {
            array_shift($data);
        }
    }

    private function _verifyOldData ($data, $id_student)
    {
        $latest_school_year = $this->_getLatestSchoolYear($id_student);
        foreach ($data as $school_year => $module)
        {
            if (!empty($latest_school_year))
            {
                if ($school_year < $latest_school_year[0]['school_year'])
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_school_year[0]['id']);
                    return;
                }

                if (empty($module) && $school_year == $latest_school_year[0]['school_year'])
                {
                    $this->_deleteWrongExamSchedules($id_student, $latest_school_year[0]['id']);
                    return;
                }
            }
        }
    }

    private function _getLatestSchoolYear ($id_student)
    {
        return $this->examScheduleDepository->getLatestSchoolYear($id_student);
    }

    private function _deleteWrongExamSchedules ($id_student, $school_year)
    {
        $this->examScheduleDepository->delete($id_student, $school_year);
    }

    protected function _updateDataVersion ($id_student)
    {
        $this->dataVersionStudentDepository->updateDataVersion($id_student, 'exam_schedule');
    }

    protected function _customInsertMultiple ($data)
    {
        $this->examScheduleDepository->insertMultiple($data);
    }

    protected function _customUpsert ($data)
    {
        $this->examScheduleDepository->upsert($data);
    }
}

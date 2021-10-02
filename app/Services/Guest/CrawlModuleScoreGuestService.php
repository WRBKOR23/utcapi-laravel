<?php


namespace App\Services\Guest;


use App\BusinessClass\CrawlQLDTData;
use App\Repositories\Contracts\GuestInfoDepositoryContract;
use App\Repositories\Contracts\ModuleScoreGuestDepositoryContract;
use App\Services\AbstractClasses\ACrawlService;

class CrawlModuleScoreGuestService extends ACrawlService
{
    private GuestInfoDepositoryContract $guestInfoDepository;
    private ModuleScoreGuestDepositoryContract $moduleScoreDepository;

    /**
     * CrawlModuleScoreService constructor.
     * @param CrawlQLDTData $crawl
     * @param GuestInfoDepositoryContract $guestInfoDepository
     * @param ModuleScoreGuestDepositoryContract $moduleScoreDepository
     */
    public function __construct (CrawlQLDTData $crawl,
                                 GuestInfoDepositoryContract $guestInfoDepository,
                                 ModuleScoreGuestDepositoryContract $moduleScoreDepository)
    {
        parent::__construct($crawl);
        $this->guestInfoDepository   = $guestInfoDepository;
        $this->moduleScoreDepository = $moduleScoreDepository;
    }

    public function crawlAll ($id_student): bool
    {
        if (!parent::crawl($id_student))
        {
            return false;
        }
        $data = $this->crawl->getStudentModuleScore(true);
        $this->_insertMultiple($data);
        $this->_updateDataVersion($id_student);

        return true;
    }

    public function crawl ($id_student): bool
    {
        if (!parent::crawl($id_student))
        {
            return false;
        }
        $data = $this->crawl->getStudentModuleScore(false);
        $this->_upsert($data);
        $this->_updateDataVersion($id_student);

        return true;
    }

    protected function _getQLDTPassword ($id_student): string
    {
        return $this->guestInfoDepository->getPassword($id_student);
    }

    protected function _updateDataVersion ($id_student)
    {
        $this->guestInfoDepository->updateDataVersion($id_student, 'Module_Score_Data_Version');
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

<?php


namespace App\Services\Guest;


use App\Repositories\Contracts\ModuleScoreGuestDepositoryContract;
use App\Services\Contracts\Guest\ModuleScoreGuestServiceContract;

class ModuleScoreGuestService implements ModuleScoreGuestServiceContract
{
    private ModuleScoreGuestDepositoryContract $moduleScoreDepository;

    /**
     * ModuleScoreGuestService constructor.
     * @param ModuleScoreGuestDepositoryContract $moduleScoreDepository
     */
    public function __construct (ModuleScoreGuestDepositoryContract $moduleScoreDepository)
    {
        $this->moduleScoreDepository = $moduleScoreDepository;
    }

    public function get ($id_student)
    {
        return $this->moduleScoreDepository->get($id_student);
    }
}

<?php


namespace App\Services;


use App\Depositories\Contracts\ModuleScoreDepositoryContract;
use App\Services\Contracts\ModuleScoreServiceContract;

class ModuleScoreService implements ModuleScoreServiceContract
{
    private ModuleScoreDepositoryContract $moduleScoreDepository;

    /**
     * ModuleScoreService constructor.
     * @param ModuleScoreDepositoryContract $moduleScoreDepository
     */
    public function __construct (ModuleScoreDepositoryContract $moduleScoreDepository)
    {
        $this->moduleScoreDepository = $moduleScoreDepository;
    }

    public function get ($id_student)
    {
        return $this->moduleScoreDepository->get($id_student);
    }
}

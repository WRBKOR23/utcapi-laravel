<?php

namespace App\Services;


use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Services\Contracts\DataVersionStudentServiceContract;

class DataVersionStudentService implements DataVersionStudentServiceContract
{
    private DataVersionStudentDepositoryContract $dataVersionStudentDepository;

    /**
     * DataVersionStudentService constructor.
     * @param DataVersionStudentDepositoryContract $dataVersionStudentDepository
     */
    public function __construct (DataVersionStudentDepositoryContract $dataVersionStudentDepository)
    {
        $this->dataVersionStudentDepository = $dataVersionStudentDepository;
    }

    public function getDataVersion ($id_student)
    {
        return $this->dataVersionStudentDepository->get($id_student);
    }
}

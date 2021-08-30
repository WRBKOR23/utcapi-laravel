<?php


namespace App\Services;


use App\Depositories\Contracts\DataVersionTeacherDepositoryContract;

class DataVersionTeacherService implements Contracts\DataVersionTeacherServiceContract
{
    private DataVersionTeacherDepositoryContract $dataVersionTeacherDepository;

    /**
     * DataVersionTeacherService constructor.
     * @param DataVersionTeacherDepositoryContract $dataVersionTeacherDepository
     */
    public function __construct (DataVersionTeacherDepositoryContract $dataVersionTeacherDepository)
    {
        $this->dataVersionTeacherDepository = $dataVersionTeacherDepository;
    }

    public function getDataVersion ($id_teacher)
    {
        return $this->dataVersionTeacherDepository->get($id_teacher);
    }
}

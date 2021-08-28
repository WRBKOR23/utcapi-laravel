<?php


namespace App\Depositories;


use App\Depositories\Contracts\FixDepositoryContract;
use App\Models\Fix;

class FixDepository implements Contracts\FixDepositoryContract
{
    private Fix $model;

    /**
     * Fix constructor.
     * @param Fix $model
     */
    public function __construct (Fix $model)
    {
        $this->model = $model;
    }

    public function getFixSchedules ($last_time_accepted)
    {
//        return $this->model->getFixSchedules($last_time_accepted);
    }
}

<?php


namespace App\Repositories\Contracts;


interface FixDepositoryContract
{
    public function getFixSchedules ($last_time_accepted);

}

<?php


namespace App\Depositories\Contracts;


interface FixDepositoryContract
{
    public function getFixSchedules ($last_time_accepted);

}

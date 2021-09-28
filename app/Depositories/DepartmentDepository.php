<?php


namespace App\Depositories;


use App\Models\Account;
use App\Models\Department;

class DepartmentDepository implements Contracts\DepartmentDepositoryContract
{
    private Department $model;

    /**
     * DepartmentDepository constructor.
     * @param Department $model
     */
    public function __construct (Department $model)
    {
        $this->model = $model;
    }

    public function get ($id_account)
    {
        return Account::find($id_account)->department;
    }
}

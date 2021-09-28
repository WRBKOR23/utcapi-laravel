<?php

    namespace App\Depositories;

    use App\Depositories\Contracts\OtherDepartmentDepositoryContract;
    use App\Models\Account;
    use App\Models\OtherDepartment;

    class OtherDepartmentDepository implements OtherDepartmentDepositoryContract
    {
        // OtherDepartment Model
        private OtherDepartment $model;

        public function __construct (OtherDepartment $model)
        {
            $this->model = $model;
        }

        public function get ($id_account)
        {
            return Account::find($id_account)->otherDepartment;
        }
    }
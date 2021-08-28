<?php

    namespace App\Depositories;

    use App\Depositories\Contracts\OtherDepartmentDepositoryContract;
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
            return $this->model->get($id_account);
        }
    }
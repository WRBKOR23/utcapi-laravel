<?php

    namespace App\Depositories;

    use App\Models\Account;
    use App\Models\Teacher;

    class TeacherDepository implements Contracts\TeacherDepositoryContract
    {
        private Teacher $model;

        /**
         * TeacherDepository constructor.
         * @param Teacher $model
         */
        public function __construct (Teacher $model)
        {
            $this->model = $model;
        }

        public function get ($id_account)
        {
            return Account::find($id_account)->teacher;
        }
    }
<?php

    namespace App\Depositories;

    use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
    use App\Models\DataVersionStudent;

    class DataVersionStudentDepository implements DataVersionStudentDepositoryContract
    {
        // DataVersionStudent Model
        private DataVersionStudent $model;

        public function __construct (DataVersionStudent $model)
        {
            $this->model = $model;
        }

        public function get ($id_student)
        {
            return $this->model->get($id_student);
        }

        public function updateDataVersion ($id_student, $type)
        {
            $this->model->updateDataVersion($id_student, $type);
        }

        public function updateMultiple ($id_notification)
        {
            $this->model->updateMultiple($id_notification);
        }

        public function updateMultiple2 ($id_student_list, $column_name)
        {
            $this->model->updateMultiple2($id_student_list, $column_name);
        }

        public function insertMultiple ($part_of_sql, $data)
        {
            $this->model->insertMultiple($part_of_sql, $data);
        }
    }

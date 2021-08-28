<?php

    namespace App\Depositories;

    use App\Models\ExamSchedule;
    use Illuminate\Support\Collection;

    class ExamScheduleDepository implements Contracts\ExamScheduleDepositoryContract
    {
        private ExamSchedule $model;

        /**
         * ExamScheduleDepository constructor.
         * @param ExamSchedule $model
         */
        public function __construct (ExamSchedule $model)
        {
            $this->model = $model;
        }

        public function get ($id_student) : Collection
        {
            return $this->model->get($id_student);
        }

        public function insertMultiple ($data)
        {
            $this->model->insertMultiple($data);
        }

        public function upsert ($data)
        {
            $this->model->upsert($data);
        }
    }

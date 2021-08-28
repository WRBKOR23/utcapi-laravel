<?php

    namespace App\Depositories;

    use App\Models\ExamScheduleGuest;
    use Illuminate\Support\Collection;

    class ExamScheduleGuestDepository implements Contracts\ExamScheduleGuestDepositoryContract
    {
        private ExamScheduleGuest $model;

        /**
         * ExamScheduleGuestDepository constructor.
         * @param ExamScheduleGuest $model
         */
        public function __construct (ExamScheduleGuest $model)
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

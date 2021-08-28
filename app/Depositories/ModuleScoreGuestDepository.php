<?php

    namespace App\Depositories;

    use App\Models\ModuleScoreGuest;
    use Illuminate\Support\Collection;

    class ModuleScoreGuestDepository implements Contracts\ModuleScoreGuestDepositoryContract
    {
        private ModuleScoreGuest $model;

        /**
         * ModuleScoreDepository constructor.
         * @param ModuleScoreGuest $model
         */
        public function __construct (ModuleScoreGuest $model)
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

        public function getALLSchoolYear ($id_student) : array
        {
            return $this->model->getAllSchoolYear($id_student);
        }

        public function getLatestSchoolYear ($id_student)
        {
            return $this->model->getLatestSchoolYear($id_student);
        }
    }

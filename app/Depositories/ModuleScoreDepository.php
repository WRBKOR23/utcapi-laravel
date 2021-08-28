<?php

    namespace App\Depositories;

    use App\Models\ModuleScore;
    use Illuminate\Support\Collection;

    class ModuleScoreDepository implements Contracts\ModuleScoreDepositoryContract
    {
        private ModuleScore $model;

        /**
         * ModuleScoreDepository constructor.
         * @param ModuleScore $model
         */
        public function __construct (ModuleScore $model)
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

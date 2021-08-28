<?php

    namespace App\Depositories\Contracts;

    interface ModuleScoreGuestDepositoryContract
    {
        public function get ($id_student);

        public function insertMultiple ($data);

        public function upsert ($data);

        public function getALLSchoolYear ($id_student);

        public function getLatestSchoolYear ($id_student);

    }

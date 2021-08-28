<?php

    namespace App\Depositories\Contracts;

    interface ExamScheduleDepositoryContract
    {
        public function get ($id_student);

        public function insertMultiple ($data);

        public function upsert ($data);
    }
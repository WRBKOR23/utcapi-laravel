<?php


    namespace App\Depositories\Contracts;


    interface DataVersionTeacherDepositoryContract
    {
        public function get ($id_teacher);

        public function getSingleColumn ($id_teacher, $column_name);
    }

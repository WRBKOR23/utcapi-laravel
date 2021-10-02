<?php


    namespace App\Repositories\Contracts;


    interface DataVersionTeacherRepositoryContract
    {
        public function get ($id_teacher);

        public function getSingleColumn ($id_teacher, $column_name);
    }

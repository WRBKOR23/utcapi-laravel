<?php

    namespace App\Repositories\Contracts;

    interface ParticipateRepositoryContract
    {
        public function getIDStudentsBMC ($class_list);

        public function insertMultiple ($data);

    }

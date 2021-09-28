<?php

    namespace App\Depositories\Contracts;

    interface ParticipateDepositoryContract
    {
        public function getIDStudentsBMC ($class_list);

        public function insertMultiple ($data);

    }

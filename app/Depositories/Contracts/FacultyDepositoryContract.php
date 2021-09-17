<?php

    namespace App\Depositories\Contracts;

    interface FacultyDepositoryContract
    {
        public function get ($id_account);

        public function getAll ($data);

    }
<?php

namespace App\Depositories\Contracts;

interface StudentDepositoryContract
{
    public function get ($id_account);

    public function getIDStudentsBFC ($class_list);

    public function insert ($data);

    public function insertMultiple ($data);

    public function updateMultiple ($id_student_list);

}

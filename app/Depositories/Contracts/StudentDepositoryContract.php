<?php

namespace App\Depositories\Contracts;

interface StudentDepositoryContract
{
    public function get ($id_account);

    public function getIDStudentsBFC ($class_list);

    public function insert ($data);

    public function insertMultiple ($part_of_sql, $data);

    public function updateMultiple ($part_of_sql, $data);

}

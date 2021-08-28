<?php

namespace App\Depositories\Contracts;

interface AccountDepositoryContract
{
    public function get ($username);

    public function getIDAccounts ($id_student_list);

    public function updateQLDTPassword ($username, $qldt_password);

    public function updatePassword ($username, $password);

    public function getQLDTPassword ($id_student);

    public function insertGetId ($data);

    public function insertMultiple ($part_of_sql, $data);

}

<?php

namespace App\Depositories\Contracts;

interface DataVersionStudentDepositoryContract
{
    public function insert ($data);

    public function get ($id_student);

    public function updateDataVersion ($id_student, $type);

    public function updateMultiple ($id_notification);

    public function updateMultiple2 ($id_student_list, $column_name);

    public function insertMultiple ($part_of_sql, $data);
}

<?php

namespace App\Depositories\Contracts;

interface DataVersionStudentDepositoryContract
{
    public function insert ($data);

    public function get ($id_student);

    public function getSingleColumn ($id_student, $column_name);

    public function updateDataVersion ($id_student, $column_name);

    public function updateMultiple ($id_student_list, $column_name);

    public function upsertMultiple ($data);
}

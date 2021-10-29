<?php

namespace App\Repositories\Contracts;

interface DataVersionStudentRepositoryContract
{
    public function insert ($data_version_student);

    public function get ($id_student);

    public function getSingleColumn1 ($id_account, $column_name);

    public function updateDataVersion ($id_student, $column_name);

    public function updateMultiple ($id_students, $column_name);
}

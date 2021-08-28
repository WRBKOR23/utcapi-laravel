<?php

namespace App\Depositories;

use App\Depositories\Contracts\StudentDepositoryContract;
use App\Models\Student;

class StudentDepository implements StudentDepositoryContract
{
    // Student Model
    private Student $model;

    public function __construct (Student $model)
    {
        $this->model = $model;
    }

    public function get ($id_account)
    {
        return $this->model->get($id_account);
    }

    public function getIDStudentsBFC ($class_list): array
    {
        return $this->model->getIDStudentsByFacultyClass($class_list);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $this->model->insertMultiple($part_of_sql, $data);
    }

    public function updateMultiple ($part_of_sql, $data)
    {
        $this->model->updateMultiple($part_of_sql, $data);
    }

    public function insert ($data)
    {
        $this->model->insert($data);
    }
}

<?php

namespace App\Depositories;

use App\Depositories\Contracts\AccountDepositoryContract;
use App\Models\Account;

class AccountDepository implements AccountDepositoryContract
{
    // Account Model
    private Account $model;

    public function __construct (Account $model)
    {
        $this->model = $model;
    }

    public function get ($username): array
    {
        return $this->model->get($username);
    }

    public function getIDAccounts ($id_student_list): array
    {
        if (empty($id_student_list))
        {
            return [];
        }

        return $this->model->getIDAccounts($id_student_list);
    }

    public function updateQLDTPassword ($username, $qldt_password)
    {
        $this->model->updateQLDTPassword($username, $qldt_password);
    }

    public function updatePassword ($username, $password)
    {
        $this->model->updatePassword($username, $password);
    }

    public function getQLDTPassword ($id_student)
    {
        return $this->model->getQLDTPassword($id_student);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $this->model->insertMultiple($part_of_sql, $data);
    }

    public function insertGetId ($data): int
    {
        return $this->model->insertGetId($data);
    }
}

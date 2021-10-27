<?php

namespace App\Repositories\Contracts;

interface AccountRepositoryContract
{
    public function insertGetId ($data);

    public function insertPivotMultiple ($id_account, $roles);

    public function get ($username);

    public function updateQLDTPassword ($username, $qldt_password);

    public function updatePassword ($username, $password);

    public function getQLDTPassword ($id_student);

    public function getPermissions ($id_account);
}

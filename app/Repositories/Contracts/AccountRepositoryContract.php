<?php

namespace App\Repositories\Contracts;

interface AccountRepositoryContract
{
    public function insertGetId ($account);

    public function insertPivotMultiple ($id_account, $roles);

    public function get ($username);

    public function getQLDTPassword ($id_account);

    public function getPermissions ($id_account);

    public function updateQLDTPassword ($id_account, $qldt_password);

    public function updatePassword ($id_account, $password);
}

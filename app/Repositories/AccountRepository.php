<?php

namespace App\Repositories;

use App\Repositories\Contracts\AccountRepositoryContract;
use App\Models\Account;

class AccountRepository implements AccountRepositoryContract
{
    public function insertGetId ($data) : int
    {
        return Account::create($data)->id;
    }

    public function insertPivotMultiple ($id_account, $roles)
    {
        Account::find($id_account)->roles()->attach($roles);
    }

    public function get ($username) : array
    {
        return Account::where('username', '=', $username)
                      ->select('id')
                      ->get()
                      ->toArray();
    }

    public function updateQLDTPassword ($username, $qldt_password)
    {
        Account::where('username', '=', $username)
               ->update(['qldt_password' => $qldt_password]);
    }

    public function updatePassword ($username, $password)
    {
        Account::where('username', '=', $username)
               ->update(['password' => $password]);
    }

    public function getQLDTPassword ($id_student)
    {
        return Account::where('username', '=', $id_student)
                      ->pluck('qldt_password')
                      ->first();
    }

    public function getPermissions ($id_account)
    {
        return Account::find($id_account)->roles()->pluck('role.id')->toArray();
    }
}

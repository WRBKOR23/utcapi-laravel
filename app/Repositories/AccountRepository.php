<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository implements Contracts\AccountRepositoryContract
{
    public function insertGetId ($account) : int
    {
        return Account::create($account)->id;
    }

    public function insertPivotMultiple ($id_account, $roles)
    {
        Account::find($id_account)->roles()->attach($roles);
    }

    public function get ($username) : array
    {
        return Account::where('username', $username)->select('id')->get()->toArray();
    }

    public function getQLDTPassword ($id_account)
    {
        return Account::select('qldt_password')->find($id_account)->qldt_password;
    }

    public function getPermissions ($id_account)
    {
        return Account::find($id_account)->roles()->pluck('role.id')->toArray();
    }

    public function updateQLDTPassword ($id_account, $qldt_password)
    {
        Account::find($id_account)->update(['qldt_password' => $qldt_password]);
    }

    public function updatePassword ($id_account, $password)
    {
        Account::find($id_account)->update(['password' => $password]);
    }
}

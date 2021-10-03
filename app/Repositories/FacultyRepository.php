<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Faculty;
use App\Repositories\Contracts\FacultyRepositoryContract;
use Illuminate\Support\Collection;

class FacultyRepository implements FacultyRepositoryContract
{
    public function get ($id_account)
    {
        return Account::find($id_account)->faculty;
    }

    public function getAll ($data) : Collection
    {
        return Faculty::whereNotIn('id', $data)
                      ->select('id as id_faculty', 'faculty_name')
                      ->get();
    }
}

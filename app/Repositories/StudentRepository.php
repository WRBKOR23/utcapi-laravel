<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\Student;

class StudentRepository implements Contracts\StudentRepositoryContract
{
    public function insert ($student)
    {
        Student::create($student);
    }

    public function get ($id_account)
    {
        return Account::find($id_account)->student;
    }
}

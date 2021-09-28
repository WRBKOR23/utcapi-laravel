<?php


namespace App\Depositories;


use App\Models\Account;
use App\Models\Faculty;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FacultyDepository implements Contracts\FacultyDepositoryContract
{
    private Faculty $model;

    /**
     * DepartmentDepository constructor.
     * @param Faculty $model
     */
    public function __construct (Faculty $model)
    {
        $this->model = $model;
    }

    public function get ($id_account)
    {
        return Account::find($id_account)->faculty;
    }

    public function getAll ($data) : Collection
    {
        return Faculty::whereNotIn('id_faculty', $data)
                 ->select('id_faculty', 'faculty_name')
                 ->get();
    }
}

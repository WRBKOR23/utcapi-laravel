<?php


namespace App\Depositories;


use App\Models\Faculty;
use Illuminate\Support\Collection;

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
        return $this->model->get($id_account);
    }

    public function getAll ($data) : Collection
    {
        return $this->model->getAll($data);
    }
}

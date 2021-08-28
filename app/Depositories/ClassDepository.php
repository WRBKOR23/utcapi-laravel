<?php

namespace App\Depositories;

use App\Models\Class_;
use Illuminate\Support\Collection;

class ClassDepository implements Contracts\ClassDepositoryContract
{
    private Class_ $model;

    /**
     * ClassDepository constructor.
     * @param Class_ $model
     */
    public function __construct (Class_ $model)
    {
        $this->model = $model;
    }

    public function getAcademicYears (): array
    {
        return $this->model->getAcademicYear();
    }

    public function getFacultyClass ($academic_year_list): Collection
    {
        return $this->model->getFacultyClass($academic_year_list);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $this->model->insertMultiple($part_of_sql, $data);
    }

    public function upsert ($data)
    {
        $this->model->upsert($data);
    }
}

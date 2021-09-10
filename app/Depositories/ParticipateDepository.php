<?php

namespace App\Depositories;

use App\Depositories\Contracts\ParticipateDepositoryContract;
use App\Models\Participate;
use PDOException;

class ParticipateDepository implements ParticipateDepositoryContract
{
    // Participate Model
    private Participate $model;

    public function __construct (Participate $model)
    {
        $this->model = $model;
    }

    public function getIDStudentsBMC ($class_list): array
    {
        return $this->model->getIDStudentsByModuleClass($class_list);
    }

    public function insertMultiple ($part_of_sql, $data)
    {
        $this->model->insertMultiple($part_of_sql, $data);
    }
}

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

    public function insertMultiple ($part_of_sql, $data): bool
    {
        try
        {
            $this->model->insertMultiple($part_of_sql, $data);
            return true;
        }
        catch (PDOException $error)
        {
            if ($error->getCode() == 23000
                && $error->errorInfo[1] == 1452)
            {
                return false;
            }
            throw $error;
        }
    }
}

<?php


namespace App\Depositories;


use App\Models\Module;

class ModuleDepository implements Contracts\ModuleDepositoryContract
{
    private Module $model;

    /**
     * ModuleDepository constructor.
     * @param Module $model
     */
    public function __construct (Module $model)
    {
        $this->model = $model;
    }

    public function getAll (): array
    {
        return $this->model->getAll();
    }
}

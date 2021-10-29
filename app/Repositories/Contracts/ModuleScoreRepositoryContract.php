<?php

namespace App\Repositories\Contracts;

interface ModuleScoreRepositoryContract
{
    public function insertMultiple ($module_scores);

    public function upsert ($module_score);

    public function get ($id_student);
}
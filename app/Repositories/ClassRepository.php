<?php

namespace App\Repositories;

use App\Models\Class_;
use App\Repositories\Contracts\ClassRepositoryContract;

class ClassRepository implements ClassRepositoryContract
{
    public function upsert ($data)
    {
        Class_::updateOrCreate(['id' => $data['id']], $data);
    }
}

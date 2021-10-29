<?php

namespace App\Repositories;

use App\Models\Class_;

class ClassRepository implements Contracts\ClassRepositoryContract
{
    public function upsert ($class)
    {
        Class_::updateOrCreate(['id' => $class['id']], $class);
    }
}

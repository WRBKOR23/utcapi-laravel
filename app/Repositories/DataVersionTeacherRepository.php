<?php

namespace App\Repositories;

use App\Models\DataVersionTeacher;
use App\Repositories\Contracts\DataVersionTeacherRepositoryContract;

class DataVersionTeacherRepository implements DataVersionTeacherRepositoryContract
{
    public function get ($id_teacher)
    {
        return DataVersionTeacher::select('schedule')->find($id_teacher);
    }

    public function getSingleColumn ($id_teacher, $column_name)
    {
        return DataVersionTeacher::where('id_teacher', '=', $id_teacher)
                                 ->pluck($column_name)->first();
    }
}

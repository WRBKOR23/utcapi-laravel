<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataVersionTeacher extends Model
{
    use HasFactory;
    public const table = 'data_version_teacher';
    public const table_as = 'data_version_teacher as dvt';

    public function get ($id_teacher)
    {
        return DB::table(self::table)
            ->where('id_teacher', '=', $id_teacher)
            ->select('schedule')
            ->get()
            ->first();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory;
    public const table = 'department';
    public const table_as = 'department as dep';

    public function get ($id_account)
    {
        return DB::table(self::table)
            ->where('id_account', '=', $id_account)
            ->get()
            ->first();
    }
}

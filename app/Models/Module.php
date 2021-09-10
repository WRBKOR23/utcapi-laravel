<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    use HasFactory;
    public const table = 'module';
    public const table_as = 'module as md';

    public function getAll(): array
    {
        return DB::table(self::table)
            ->select('id_module', 'module_name')
            ->get()
            ->toArray();
    }
}

<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class OtherDepartment extends Model
    {
        use HasFactory;

        public const table = 'other_department';
        public const table_as = 'other_department as od';

        public function get ($id_account)
        {
            return DB::table(self::table)
                ->where('id_account', '=', $id_account)
                ->get()
                ->first();
        }
    }

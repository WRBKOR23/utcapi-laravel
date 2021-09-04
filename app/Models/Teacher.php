<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Teacher extends Model
    {
        public const table = 'teacher';
        public const table_as = 'teacher as tea';

        public function get ($id_account)
        {
            return DB::table(self::table)
                ->where('id_account', '=', $id_account)
                ->get()
                ->first();
        }
    }

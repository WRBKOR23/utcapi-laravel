<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Faculty extends Model
    {
        use HasFactory;

        public const table = 'faculty';
        public const table_as = 'faculty as fac';

        public function get ($id_account)
        {
            return DB::table(self::table)
                ->where('id_account', '=', $id_account)
                ->get()
                ->first();
        }
    }

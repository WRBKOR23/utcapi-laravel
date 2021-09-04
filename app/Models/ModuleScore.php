<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;

    class ModuleScore extends Model
    {
        use HasFactory;

        public const table = 'module_score';
        public const table_as = 'module_score as ms';

        public function get ($id_student) : Collection
        {
            return DB::connection('mysql2')->table(self::table)
                ->where('id_student', '=', $id_student)
                ->select('id_module_score', 'school_year', 'module_name', 'credit', 'evaluation',
                    'process_score', 'test_score', 'theoretical_score')
                ->get();
        }

        public function insertMultiple ($data)
        {
            DB::connection('mysql2')->table(self::table)
                ->insert($data);
        }

        public function upsert ($data)
        {
            DB::connection('mysql2')->table(self::table)
                ->updateOrInsert([
                    'school_year' => $data['school_year'],
                    'id_module' => $data['id_module'],
                    'id_student' => $data['id_student']
                ], $data);
        }

        public function getAllSchoolYear ($id_student) : array
        {
            return DB::connection('mysql2')->table(self::table)
                ->where('id_student', '=', $id_student)
                ->distinct()
                ->orderBy('school_year')
                ->pluck('school_year')
                ->toArray();
        }

        public function getLatestSchoolYear ($id_student)
        {
            return DB::connection('mysql2')->table(self::table)
                ->where('id_student', '=', $id_student)
                ->distinct()
                ->orderBy('school_year', 'desc')
                ->pluck('school_year')
                ->first();
        }
    }

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
                ->where('ID_Student', '=', $id_student)
                ->select('ID', 'School_Year', 'Module_Name', 'Credit', 'Evaluation',
                    'Process_Score', 'Test_Score', 'Theoretical_Score')
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
                    'School_Year' => $data['School_Year'],
                    'ID_Module' => $data['ID_Module'],
                    'ID_Student' => $data['ID_Student']
                ], $data);
        }

        public function getAllSchoolYear ($id_student) : array
        {
            return DB::connection('mysql2')->table(self::table)
                ->where('ID_Student', '=', $id_student)
                ->distinct()
                ->orderBy('School_Year')
                ->pluck('School_Year')
                ->toArray();
        }

        public function getLatestSchoolYear ($id_student)
        {
            return DB::connection('mysql2')->table(self::table)
                ->where('ID_Student', '=', $id_student)
                ->distinct()
                ->orderBy('School_Year', 'desc')
                ->pluck('School_Year')
                ->first();
        }
    }

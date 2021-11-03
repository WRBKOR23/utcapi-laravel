<?php

namespace Database\Seeders;

use App\Helpers\SharedFunctions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run ()
    {
        $student      = [];
        $module_class = [];
        $participate1 = [];
        $participate2 = [];
        //        for ($i = 0; $i < 6; $i++)
        //        {
        //            $module_class[] = [
        //                'id_module_class' => Str::random(30),
        //                'name'            => Str::random(50),
        //            ];
        //        }
        //
        //        DB::connection('mysql')
        //          ->table('module_class')
        //          ->upsert($module_class, ['id_module_class'], ['name']);
        //
        //        DB::connection('mysql2')
        //          ->table('module_class')
        //          ->upsert($module_class, ['id_module_class'], ['name']);

        for ($j = 0; $j < 2; $j++)
        {
            $student = [];
            //                        echo now() . PHP_EOL;
            for ($i = 0; $i < 5000; $i++)
            {
                $aa        = Str::orderedUuid();
                $student[] = [
                    'uuid'       => DB::raw('UuidToBin(\'' . $aa . '\')'),
                    'name'       => Str::random(50),
                    'birth'      => '1996-12-20',
                    'id_class'   => 'K55.CTGTCC',
                    'test'       => rand(1, 3),
                    'id_account' => rand(1, 30),
                ];
                //                echo $aa . PHP_EOL;

                //                try
                //                {
                //                    DB::connection('mysql')
                //                      ->table('studentt')
                //                      ->insert($student);
                //                } catch (\PDOException $e)
                //                {
                //                    echo 'end' . PHP_EOL;
                //                    SharedFunctions::printError($e);
                //                    exit();
                //                }
                //
                //                if ($i > 0)
                //                {
                //                    $a = rand(1, $i > 4000 ? 4000 : $i);
                //                    $b = rand(1, 5);
                //
                //                    $participate1[] = [
                //                        'id_module_class' => $module_class[$b]['id_module_class'],
                //                        'id_student'      => $student[$a]['id_student'],
                //                    ];
                //
                //                    $participate2[] = [
                //                        'id_module_class_sg' => $b,
                //                        'id_student_sg'      => $a,
                //                    ];
                //                }
            }
            //            $a = now() . PHP_EOL;
            //            echo $a;
            try
            {
                DB::connection('mysql')
                  ->table('studentt')
                  ->insert($student);
            }
            catch (\PDOException $e)
            {
                echo 'end' . PHP_EOL;
            }
            //            echo now() . PHP_EOL;
            //            DB::connection('mysql')
            //              ->table('participate')
            //              ->upsert($participate1, ['id_student', 'id_module_class'], ['id_student']);


            //            DB::connection('mysql2')
            //              ->table('student')
            //              ->upsert($student, ['id_student'], ['id_class']);
            //
            //            DB::connection('mysql2')
            //              ->table('participate')
            //              ->upsert($participate2, ['id_student_sg', 'id_module_class_sg'], ['id_student_sg']);
        }
    }
}

//[Symfony\Component\Process\Exception\RuntimeException]
//  The Process class relies on proc_open, which is not available on your PHP installation.
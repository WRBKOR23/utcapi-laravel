<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        for ($i = 0; $i < 50000; $i++)
        {
            DB::connection('mysql2')
              ->table('student')
              ->updateOrInsert(
                  [
                      'id_student' => Str::random(15),
                  ],
                  [
                      'student_name'   => Str::random(50),
                      'birth'          => '1996-12-20',
                      'id_class'       => 'K55.CTGTCC',
                      'id_card_number' => Str::random(12),
                      'phone_number'   => Str::random(10),
                      'address'        => Str::random(150),
                      'id_account'     => 1234,
                  ]
              );

            DB::connection('mysql2')
              ->table('studentt')
              ->updateOrInsert(
                  [
                      'id_student' => Str::random(15),
                  ],
                  [
                      'student_name'   => Str::random(50),
                      'birth'          => '1996-12-20',
                      'id_class'       => 'K55.CTGTCC',
                      'id_card_number' => Str::random(12),
                      'phone_number'   => Str::random(10),
                      'address'        => Str::random(150),
                      'id_account'     => 1234,
                  ]
              );
        }
    }
}

//[Symfony\Component\Process\Exception\RuntimeException]
//  The Process class relies on proc_open, which is not available on your PHP installation.
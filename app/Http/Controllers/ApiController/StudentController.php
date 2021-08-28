<?php

    namespace App\Http\Controllers\ApiController;

    use App\Http\Controllers\Controller;
    use App\Models\Student;

    class StudentController extends Controller
    {
        public function getInfo ($id_account) : array
        {
            $student = new Student();
            $data    = $student->get($id_account);

            return $data;
        }
    }

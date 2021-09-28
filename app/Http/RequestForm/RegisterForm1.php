<?php

namespace App\Http\RequestForm;

class RegisterForm1 extends BaseForm
{

    protected function getRules () : array
    {
        return [
            'id_student'    => 'required',
            'qldt_password' => 'required',
        ];
    }
}
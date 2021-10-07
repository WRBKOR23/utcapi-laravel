<?php

namespace App\Http\FormRequest;

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
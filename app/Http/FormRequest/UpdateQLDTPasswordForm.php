<?php

namespace App\Http\FormRequest;

class UpdateQLDTPasswordForm extends BaseForm
{
    protected function getRules () : array
    {
        return [
            'id_student'    => 'required',
            'qldt_password' => 'required|min:3'
        ];
    }
}

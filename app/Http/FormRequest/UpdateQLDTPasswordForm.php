<?php

namespace App\Http\FormRequest;

class UpdateQLDTPasswordForm extends BaseForm
{
    protected function getRules () : array
    {
        return [
            'id_account'    => 'required',
            'id_student'    => 'required',
            'qldt_password' => 'required|min:3'
        ];
    }
}

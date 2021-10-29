<?php

namespace App\Http\FormRequest;

class ChangePasswordForm extends BaseForm
{
    protected function getRules () : array
    {
        return [
            'id_account'   => 'required',
            'username'     => 'required',
            'password'     => 'required',
            'new_password' => 'required|min:4'
        ];
    }
}

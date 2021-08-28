<?php

namespace App\Http\RequestForm;


class LoginForm extends BaseForm
{
    protected function getRules (): array
    {
        return [
            'username' => 'required',
            'password' => 'required|min:3'
        ];
    }
}

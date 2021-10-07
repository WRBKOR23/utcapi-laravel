<?php

namespace App\Http\FormRequest;

class PushNotificationForm extends BaseForm
{
    protected function getRules () : array
    {
        return [
            'token'      => 'required',
            'class_list' => 'required',
            'info'       => 'required'
        ];
    }
}

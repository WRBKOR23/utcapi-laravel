<?php


namespace App\Http\RequestForm;


class UpdateDeviceTokenForm extends BaseForm
{

    protected function getRules ()
    {
        return [
            'id_student'   => 'required',
            'device_token' => 'required|min:30'
        ];
    }
}

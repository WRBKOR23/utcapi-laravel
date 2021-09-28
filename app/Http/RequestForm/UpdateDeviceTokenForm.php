<?php


namespace App\Http\RequestForm;


class UpdateDeviceTokenForm extends BaseForm
{

    protected function getRules (): array
    {
        return [
            'id_account'   => 'required',
            'device_token' => 'required|min:30'
        ];
    }
}

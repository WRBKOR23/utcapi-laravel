<?php

namespace App\Http\FormRequest;

use App\Exceptions\InvalidFormRequestException;
use Exception;
use Illuminate\Http\Request;

class PushNotificationGuestForm extends BaseForm
{
    protected function getRules () : array
    {
        return [
            'id_notification' => 'required',
            'academic_year'   => 'required',
            'faculty'         => 'required',
            'info'            => 'required'
        ];
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function validate (Request $request)
    {
        try
        {
            parent::validate($request);

        }
        catch (Exception $exception)
        {
            throw new InvalidFormRequestException();
        }
    }
}

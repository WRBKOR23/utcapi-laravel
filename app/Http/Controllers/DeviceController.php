<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidFormRequestException;
use App\Http\FormRequest\UpdateDeviceTokenForm;
use App\Services\Contracts\DeviceServiceContract;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    private UpdateDeviceTokenForm $form;
    private DeviceServiceContract $deviceService;

    /**
     * @param UpdateDeviceTokenForm $form
     * @param DeviceServiceContract $deviceService
     */
    public function __construct (UpdateDeviceTokenForm $form, DeviceServiceContract $deviceService)
    {
        $this->form          = $form;
        $this->deviceService = $deviceService;
    }

    /**
     * @throws InvalidFormRequestException
     */
    public function updateDeviceToken (Request $request)
    {
        $this->form->validate($request);
        $this->deviceService->upsert($request->id_account, $request->device_token);
    }
}

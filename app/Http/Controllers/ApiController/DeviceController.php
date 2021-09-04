<?php

    namespace App\Http\Controllers\ApiController;

    use App\Exceptions\InvalidFormRequestException;
    use App\Http\Controllers\Controller;
    use App\Http\RequestForm\UpdateDeviceTokenForm;
    use App\Services\Contracts\DeviceServiceContract;
    use Illuminate\Http\Request;

    class DeviceController extends Controller
    {
        private UpdateDeviceTokenForm $form;
        private DeviceServiceContract $deviceService;

        /**
         * DeviceController constructor.
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

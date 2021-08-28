<?php

namespace App\Services\Contracts;

interface AccountServiceContract
{
    public function updateQLDTPassword ($username, $qldt_password);

    public function changePassword ($username, $password, $new_password);

}

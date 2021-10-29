<?php

namespace App\Services\Contracts;

interface AccountServiceContract
{
    public function updateQLDTPassword ($input);

    public function changePassword ($input);
}

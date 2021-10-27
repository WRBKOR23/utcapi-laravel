<?php

namespace App\Repositories\Contracts;

interface ClassRepositoryContract
{
    public function upsert ($data);
}

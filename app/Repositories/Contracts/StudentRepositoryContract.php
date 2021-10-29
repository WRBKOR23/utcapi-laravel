<?php

namespace App\Repositories\Contracts;

interface StudentRepositoryContract
{
    public function insert ($student);

    public function get ($id_account);
}

<?php


namespace App\Services\Contracts\Guest;


interface LoginGuestServiceContract
{
    public function login($id_student, $password);
}

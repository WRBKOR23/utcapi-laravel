<?php


namespace App\Http\RequestForm;


class RegisterForm extends BaseForm
{

  protected function getRules (): array
  {
      return [
          'id_student' => 'required',
          'password' => 'required',
          'qldt_password' => 'required',
          'id_class' => 'required',
      ];  }
}

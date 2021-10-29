<?php

namespace App\Http\FormRequest;

class CrawlForm extends BaseForm
{
    protected function getRules () : array
    {
        return [
            'id_account' => 'required',
            'id_student' => 'required',
        ];
    }
}

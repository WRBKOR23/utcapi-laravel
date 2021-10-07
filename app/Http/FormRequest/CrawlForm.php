<?php

namespace App\Http\FormRequest;

class CrawlForm extends BaseForm
{
    protected function getRules () : array
    {
        return [
            'id_student' => 'required',
        ];
    }
}

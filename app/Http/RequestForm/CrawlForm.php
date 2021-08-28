<?php


namespace App\Http\RequestForm;


class CrawlForm extends BaseForm
{

    protected function getRules (): array
    {
        return [
            'id_student' => 'required',
        ];
    }
}

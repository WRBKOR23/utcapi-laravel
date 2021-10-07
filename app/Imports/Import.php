<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Import implements WithMultipleSheets
{
    public function sheets (): array
    {
        return [
            new FileImport(),
            new FileImport()

        ];
    }
}

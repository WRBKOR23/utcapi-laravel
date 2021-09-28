<?php

namespace App\Depositories\Contracts;

interface ClassDepositoryContract
{
    public function getAcademicYears ();

    public function getFacultyClass ($academic_year_list);

    public function insertMultiple ($data);

    public function upsert ($data);

}

<?php

namespace App\Depositories\Contracts;

interface ClassDepositoryContract
{
    public function getAcademicYears ();

    public function getFacultyClass ($academic_year_list);

    public function insertMultiple ($part_of_sql, $data);

    public function upsert ($data);

}

<?php

namespace App\Depositories\Contracts;

interface ExamScheduleDepositoryContract
{
    public function get ($id_student);

    public function getLatestSchoolYear ($id_student);

    public function insertMultiple ($data);

    public function upsert ($data);

    public function delete ($id_student, $school_year);
}
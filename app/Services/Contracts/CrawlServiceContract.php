<?php

namespace App\Services\Contracts;

interface CrawlServiceContract
{
    public function crawlAll ($id_student);

    public function crawl ($id_student);

    public function crawlBySchoolYear ($id_student, $school_year);
}

<?php

namespace App\Depositories;

use App\Models\ModuleScore;
use App\Models\Student;
use Illuminate\Support\Collection;

class ModuleScoreDepository implements Contracts\ModuleScoreDepositoryContract
{
    private ModuleScore $model;

    /**
     * ModuleScoreDepository constructor.
     * @param ModuleScore $model
     */
    public function __construct (ModuleScore $model)
    {
        $this->model = $model;
    }

    public function get ($id_student) : Collection
    {
        return Student::find($id_student)->moduleScores()
                      ->orderBy('school_year')
                      ->select('id_module_score', 'school_year', 'module_name', 'credit', 'evaluation',
                               'process_score', 'test_score', 'theoretical_score')
                      ->get();
    }

    public function insertMultiple ($data)
    {
        ModuleScore::insert($data);
    }

    public function upsert ($data)
    {
        ModuleScore::upsert($data,
                            ['school_year', 'id_module_class', 'id_student'],
                            ['evaluation', 'process_score', 'test_score', 'theoretical_score']);
    }
}

<?php

namespace App\Repositories;

use App\Models\ModuleScore;
use App\Models\Student;
use Illuminate\Support\Collection;

class ModuleScoreRepository implements Contracts\ModuleScoreRepositoryContract
{
    public function insertMultiple ($module_scores)
    {
        ModuleScore::insert($module_scores);
    }

    public function upsert ($module_score)
    {
        ModuleScore::upsert($module_score,
                            ['term', 'id_module_class', 'id_student'],
                            [
                                'evaluation', 'process_score',
                                'test_score', 'final_score'
                            ]);
    }

    public function get ($id_student) : Collection
    {
        return Student::find($id_student)->moduleScores()->orderBy('id_term')
                      ->get(['id as id_module_score', 'id_term', 'module_name',
                             'credit', 'evaluation', 'process_score',
                             'test_score', 'final_score']);
    }
}

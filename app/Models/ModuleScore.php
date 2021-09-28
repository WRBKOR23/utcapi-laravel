<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ModuleScore extends Model
{
    use HasFactory;

    public const table = 'module_score';
    public const table_as = 'module_score as ms';

    protected $table = 'module_score';
    protected $primaryKey = 'id_module_score';
    public $timestamps = false;

    protected $fillable = [
        'id_exam_schedule',
        'school_year',
        'id_student',
        'id_module',
        'module_name',
        'credit',
        'evaluation',
        'process_score',
        'test_score',
        'theoretical_score'
    ];

    public function student () : BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_student', 'id_student');
    }
}

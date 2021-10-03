<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSchedule extends Model
{
    use HasFactory;

    public const table = 'exam_schedule';
    public const table_as = 'exam_schedule as es';

    protected $table = 'exam_schedule';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'school_year',
        'id_student',
        'id_module',
        'module_name',
        'credit',
        'date_start',
        'time_start',
        'method',
        'identification_number',
        'room'
    ];

    public function student () : BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_student', 'id');
    }
}

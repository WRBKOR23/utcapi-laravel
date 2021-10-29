<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYear extends Model
{
    use HasFactory;

    public const table = 'school_year';
    public const table_as = 'school_year as sy';

    protected $table = 'school_year';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'school_year',
    ];

    public function examSchedules() : HasMany
    {
        return $this->hasMany(ExamSchedule::class, 'id_school_year', 'id');
    }

    public function moduleScores() : HasMany
    {
        return $this->hasMany(ModuleScore::class, 'id_school_year', 'id');
    }
}

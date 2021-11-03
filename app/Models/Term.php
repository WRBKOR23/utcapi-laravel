<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory;

    public const table = 'term';
    public const table_as = 'term as te';

    protected $table = 'term';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function examSchedules () : HasMany
    {
        return $this->hasMany(ExamSchedule::class, 'id_term', 'id');
    }

    public function moduleScores () : HasMany
    {
        return $this->hasMany(ModuleScore::class, 'id_term', 'id');
    }
}

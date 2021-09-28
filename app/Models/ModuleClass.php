<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ModuleClass extends Model
{
    use HasFactory;

    public const table = 'module_class';
    public const table_as = 'module_class as mc';

    protected $table = 'module_class';
    protected $primaryKey = 'id_module_class';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_module_class',
        'module_class_name',
        'number_plan',
        'number_reality',
        'school_year',
        'id_teacher',
        'id_module'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function department () : BelongsTo
    {
        return $this->belongsTo(Module::class, 'id_module', 'id_module');
    }

    public function schedules () : HasMany
    {
        return $this->hasMany(Schedule::class, 'id_module_class', 'id_module_class');
    }

    public function students () : BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'participate', 'id_module_class', 'id_student');
    }
}

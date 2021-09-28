<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Module extends Model
{
    use HasFactory;

    public const table = 'module';
    public const table_as = 'module as md';

    protected $table = 'module';
    protected $primaryKey = 'id_module';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_module',
        'module_name',
        'credit',
        'semester',
        'theory',
        'practice',
        'exercise',
        'project',
        'option',
        'id_department'
    ];

    public function department () : BelongsTo
    {
        return $this->belongsTo(Department::class, 'id_department', 'id_department');
    }

    public function moduleClasses() : HasMany
    {
        return $this->hasMany(ModuleClass::class, 'id_module', 'id_module');
    }
}

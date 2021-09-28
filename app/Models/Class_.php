<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Class_ extends Model
{
    use HasFactory;

    public const table = 'class';
    public const table_as = 'class as cl';

    protected $table = 'class';
    protected $primaryKey = 'id_class';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_class',
        'academic_year',
        'class_name',
        'id_faculty'
    ];

    public function students () : HasMany
    {
        return $this->hasMany(Student::class, 'id_class', 'id_class');
    }
}

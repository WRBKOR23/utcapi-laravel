<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Class_ extends Model
{
    use HasFactory;

    public const table = 'class';
    public const table_as = 'class as cl';

    protected $table = 'class';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'academic_year',
        'class_name',
        'id_faculty'
    ];

    public function students () : HasMany
    {
        return $this->hasMany(Student::class, 'id_class', 'id');
    }
}

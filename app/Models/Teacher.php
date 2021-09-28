<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teacher extends Model
{
    use HasFactory;

    public const table = 'teacher';
    public const table_as = 'teacher as tea';

    protected $table = 'teacher';
    protected $primaryKey = 'id_teacher';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_teacher',
        'teacher_name',
        'birth',
        'phone_number',
        'email',
        'university_teacher_degree',
        'id_department',
        'is_delete',
        'id_account'
    ];

    public function dataVersionTeacher () : HasOne
    {
        return $this->hasOne(DataVersionTeacher::class, 'id_teacher', 'id_teacher');
    }

    public function moduleClasses () : HasMany
    {
        return $this->hasMany(ModuleClass::class, 'id_teacher', 'id_teacher');
    }
}

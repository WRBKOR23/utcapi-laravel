<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    public const table = 'student';
    public const table_as = 'student as stu';

    use HasFactory;

    protected $table = 'student';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'student_name',
        'birth',
        'id_class',
        'id_card_number',
        'phone_number',
        'address',
        'id_account'
    ];

    public function account () : BelongsTo
    {
        return $this->belongsTo(Account::class, 'id_account', 'id');
    }

    public function class_ () : BelongsTo
    {
        return $this->belongsTo(Class_::class, 'id_faculty', 'id');
    }

    public function moduleClasses () : BelongsToMany
    {
        return $this->belongsToMany(ModuleClass::class, 'participate', 'id_student', 'id_module_class');
    }

    public function dataVersionStudent () : HasOne
    {
        return $this->hasOne(DataVersionStudent::class, 'id_student', 'id');
    }

    public function moduleScores () : HasMany
    {
        return $this->hasMany(ModuleScore::class, 'id_student', 'id');
    }

    public function examSchedules () : HasMany
    {
        return $this->hasMany(ExamSchedule::class, 'id_student', 'id');
    }
}

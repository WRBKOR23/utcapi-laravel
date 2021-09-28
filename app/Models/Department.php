<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory;

    public const table = 'department';
    public const table_as = 'department as dep';

    protected $table = 'department';
    protected $primaryKey = 'id_department';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_department',
        'department_name',
        'email',
        'phone_number',
        'address',
        'id_faculty',
        'id_account'
    ];

    public function account () : HasOne
    {
        return $this->hasOne(Account::class, 'id_account', 'id_account');
    }

    public function faculty () : BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'id_faculty', 'id_faculty');
    }

    public function modules() : HasMany
    {
        return $this->hasMany(Module::class, 'id_department', 'id_department');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Faculty extends Model
{
    use HasFactory;

    public const table = 'faculty';
    public const table_as = 'faculty as fac';

    protected $table = 'faculty';
    protected $primaryKey = 'id_faculty';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_faculty',
        'faculty_name',
        'email',
        'phone_number',
        'address',
        'id_account'
    ];

    public function account () : HasOne
    {
        return $this->hasOne(Account::class, 'id_account', 'id_account');
    }

    public function departments() : HasMany
    {
        return $this->hasMany(Department::class, 'id_faculty', 'id_faculty');
    }

    public function classes() : HasMany
    {
        return $this->hasMany(Class_::class, 'id_faculty', 'id_faculty');
    }
}

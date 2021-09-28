<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    public const table = 'account';
    public const table_as = 'account as acc';

    protected $table = 'account';
    protected $primaryKey = 'id_account';
    public $timestamps = false;

    protected $fillable = [
        'id_account',
        'username',
        'email',
        'password',
        'qldt_password',
        'permission'
    ];

    public function student () : BelongsTo
    {
        return $this->belongsTo(Student::class, 'id_account', 'id_account');
    }

    public function teacher () : BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'id_account', 'id_account');
    }

    public function otherDepartment () : BelongsTo
    {
        return $this->belongsTo(OtherDepartment::class, 'id_account', 'id_account');
    }

    public function department () : BelongsTo
    {
        return $this->belongsTo(Department::class, 'id_account', 'id_account');
    }

    public function faculty () : BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'id_account', 'id_account');
    }

    public function devices() : HasMany
    {
        return $this->hasMany(Device::class, 'id_account', 'id_account');
    }

    public function notifications () : BelongsToMany
    {
        return $this->belongsToMany(Notification::class, 'notification_account',
                                    'id_account', 'id_notification');
    }
}

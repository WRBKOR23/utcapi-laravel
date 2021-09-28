<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class NotificationAccount extends Model
{
    use HasFactory;

    public const table = 'notification_account';
    public const table_as = 'notification_account as na';

    protected $table = 'notification_account';
    protected $primaryKey = 'id_notification_account';
    public $timestamps = false;

    protected $fillable = [
        'id_notification_account',
        'id_notification',
        'id_account'
    ];
}

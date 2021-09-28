<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    use HasFactory;

    public const table = 'notification';
    public const table_as = 'notification as noti';

    protected $table = 'notification';
    protected $primaryKey = 'id_notification';
    public $timestamps = false;

    protected $fillable = [
        'id_notification',
        'title',
        'content',
        'type',
        'id_sender',
        'time_create',
        'time_start',
        'time_end',
        'id_delete'
    ];

    protected $hidden = [
        'is_delete',
        'pivot'
    ];

    public function accounts () : BelongsToMany
    {
        return $this->belongsToMany(Account::class, 'notification_account',
                                    'id_notification', 'id_account');
    }
}

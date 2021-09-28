<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    use HasFactory;

    public const table = 'schedule';
    public const table_as = 'schedule as sdu';

    protected $table = 'schedule';
    protected $primaryKey = 'id_schedule';
    public $timestamps = false;

    protected $fillable = [
        'id_schedule',
        'id_module_class',
        'id_room',
        'shift',
        'date',
        'number_student'
    ];

    public function moduleClass () : BelongsTo
    {
        return $this->belongsTo(ModuleClass::class, 'id_module_class', 'id_module_class');
    }
}

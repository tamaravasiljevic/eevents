<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ActivityLog\Events\Handlers\Auth;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Traits\LogsActivity;

//use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLog extends BaseModel
{
    use CrudTrait;
    use LogsActivity;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'activity_log';

    protected $casts = [
        'properties' => 'array'
    ];

    public function getCausedByAttribute()
    {
        return $this->causer->name ?? 'unknown';
    }

    public function getSubjectTypeNameAttribute()
    {
        return explode("\\", $this->subject_type)[2] ?? 'unknown';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function causer() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logActivityAdditional() : BelongsTo
    {
        return $this->belongsTo(LogActivity::class,'id', 'model_id');
    }
}

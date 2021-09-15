<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\ActivityLog\Events\Handlers\Auth;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Traits\LogsActivity;

//use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLog extends Model
{
    use Notifiable;
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
    protected $collection = 'activity_log';
    protected $connection = 'mongodb';

    protected $fillable = ['caused_by', 'description'];

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

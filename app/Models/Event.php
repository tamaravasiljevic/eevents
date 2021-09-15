<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use App\Http\Traits\LogsActivityCustom;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Event extends Model
{
    use CrudTrait;
    use Notifiable;
    use LogsActivityCustom;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const VISIBILITY_PUBLIC     = 1;
    const VISIBILITY_PRIVATE    = 2;
    const VISIBILITY_DRAFT      = 3;

    const STATUS_ACTIVE         = 1;
    const STATUS_INACTIVE       = 0;

    protected $table = 'events';
    protected $guarded = ['id'];
    protected $collection = 'events';

    protected static $logAttributes = ['company_id', 'venue_id', 'name', 'description', 'currency', 'visibility',
        'status', 'total_capacity', 'event_type_id', 'sold_out', 'starts_at', 'ends_at', 'sale_end_date_time'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setStartsAtAttribute($value) {
        $this->attributes['starts_at'] = Date::parse($value);
    }

    public function setEndsAtAttribute($value) {
        $this->attributes['ends_at'] = Date::parse($value);
    }

}

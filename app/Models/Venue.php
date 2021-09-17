<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Venue extends BaseModel
{
    use CrudTrait;
    use Notifiable;
    use LogsActivity;

    protected $collection = 'venues';
    protected $fillable = ['name', 'address', 'city', 'state', 'timezone', 'company_id', 'country_id'];

    protected static $logAttributes = ['name', 'address', 'city', 'state', 'timezone', 'company_id', 'country_id'];

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

    public function getConnectionName()
    {
        return config('database.default');
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function getCountryNameAttribute()
    {
        return $this->country->name ?? null;
    }
}

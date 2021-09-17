<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use App\Http\Traits\LogsActivityCustom;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Jenssegers\Mongodb\Eloquent\Model;

class Company extends BaseModel
{
    use Notifiable;
    use CrudTrait;
    use LogsActivityCustom;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'companies';
    protected $collection='companies';
    protected $connection='mongodb';

    protected $guarded = ['id'];
    protected static $logAttributes = ['name', 'description', 'email', 'phone', 'website', 'facebook_url', 'twitter_url',
        'instagram_url', 'linkedin_url'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getConnectionName()
    {
        return config('database.default');
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
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
}

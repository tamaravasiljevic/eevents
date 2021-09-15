<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use App\Http\Traits\LogsActivityCustom;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EventType extends Model
{
    use CrudTrait;
    use Notifiable;
    use LogsActivityCustom;

    protected $collection = 'event_types';
    protected $connection = 'mongodb';

    protected $fillable = ['name'];
    protected static $logAttributes = ['name'];


}

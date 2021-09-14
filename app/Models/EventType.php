<?php

namespace App\Models;

use App\Http\Traits\LogsActivityCustom;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Jenssegers\Mongodb\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EventType extends Model
{
    use CrudTrait;
    use LogsActivityCustom;

    protected $table = 'event_types';

    protected $fillable = ['name'];
    protected static $logAttributes = ['name'];
}

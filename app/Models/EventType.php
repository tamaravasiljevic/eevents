<?php

namespace App\Models;

use Alexzvn\LaravelMongoNotifiable\Notifiable;
use App\Http\Traits\LogsActivityCustom;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
class EventType extends BaseModel
{
    use CrudTrait;
    use Notifiable;
    use LogsActivityCustom;

    protected $collection = 'event_types';
    protected $connection = 'mongodb';

    protected $fillable = ['name'];
    protected static $logAttributes = ['name'];


}

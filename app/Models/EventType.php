<?php

namespace App\Models;

use App\Http\Traits\LogsActivityCustom;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class EventType extends BaseModel
{
    use CrudTrait;
    use LogsActivityCustom;

    protected $table = 'event_types';

    protected $fillable = ['name'];

    protected static $logAttributes = ['name'];
}

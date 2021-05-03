<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use LogsActivity;

    const ROLE_ADMINISTRATOR = 'Administrator';
    const ROLE_DEVELOPER = 'Developer';
    const ROLE_CLIENT = 'Client';

    protected $fillable = [
        'name'
    ];

    protected static $logAttributes = ['name'];

    public $timestamps = false;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class RoleUser extends Model
{

    use LogsActivity;

    protected $table='role_user';

    protected $fillable = [
        'user_id', 'role_id'
    ];

    protected static $logAttributes = ['role_id', 'user_id'];


    public $timestamps = false;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role() : BelongsTo
    {
        return $this->belongsTo(Roles::class);
    }
}

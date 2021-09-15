<?php

namespace App\Models;

use App\Http\Traits\LogsActivityCustom;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use \Alexzvn\LaravelMongoNotifiable\Notifiable;
    use CrudTrait;
    use LogsActivityCustom;

    protected $collection = 'users';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone', 'timezone', 'language','random'
    ];

    protected static $logAttributes = [ 'first_name', 'last_name', 'email', 'password', 'phone', 'timezone', 'language'];

    protected static $logOnlyDirty = true;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getConnectionName()
    {
        return config('database.default');
    }

    public static function boot()
    {
        parent::boot();
    }

    public function roles()  : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return string
     */
    public function getFullNameEmailAttribute(): string
    {
        return $this->fullName.' ('.$this->email.')';
    }
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('cover_image');

        $this->addMediaConversion('profile_image');

        $this
            ->addMediaConversion('icon')
            ->crop(Manipulations::CROP_TOP, 64, 64);
    }

    public function images() : MorphMany
    {
        return $this->morphMany(Media::class, "model");
    }

    /**
     * Set new password mutator.
     *
     * @param $password
     */
    public function setNewPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->password = Hash::make($password);
        }
    }

}



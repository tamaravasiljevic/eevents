<?php

namespace App\Models;

use App\Http\Traits\LogsActivityCustom;
use App\Traits\ActivityTraits;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait;
    use LogsActivityCustom;


    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone', 'timezone', 'language'
    ];

    protected static $logAttributes = [ 'first_name', 'last_name', 'email', 'password', 'phone', 'timezone', 'language'];

    protected static $logOnlyDirty = true;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        static::updating(/**
         * @param $obj
         */
            function ($obj){
            if(request()->input('password')) {
                request()->merge(['password' => \Hash::make(request()->input('password'))]);
            }


        });
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



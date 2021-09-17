<?php
namespace App\Models;

class LogActivity extends BaseModel
{

    protected $table = "log_activities";

    const CREATE = "CREATE";
    const UPDATE = "UPDATE";
    const DELETE = "DELETE";

    /**
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'user_agent',
        'model_type',
        'action',
        'attributes',
        'model_id',
        'action',
        'user_id'
    ];

    protected $casts = [
        'attributes' => 'array',
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public $appends = [
        'action_nice_name',
        'ip_address_nice'
    ];

    public static function getAction($key = null)
    {
        $entries = [
            self::CREATE => 'Create',
            self::UPDATE => 'Update',
            self::DELETE => 'Delete'
        ];

        return is_null($key) ? $entries : data_get($entries, $key, null);
    }

    public function getIpAddressNiceAttribute()
    {
        return long2ip(is_null($this->ip_address) ? 0 : $this->ip_address);
    }

    public function getActionNiceNameAttribute()
    {
        return self::getAction($this->action);
    }

    public function auth()
    {
        return $this->belongsTo(User::class, 'auth_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function (self $model) {

            /** @var Request $request */
            $request = app('request');

            if (is_null($model->ip_address)) {
                $model->ip_address =  request()->ip() ?? "127.0.0.1";
            }

            if (is_null($model->user_agent)) {
                $model->user_agent = request()->header('User-Agent') ?? null;
            }

            if (!is_null($model->attributes) && !is_array($model->attributes) && is_callable([$model, 'toArray'])) {
                $model->attributes = $model->attributes->toArray();
            }

            if (is_null($model->auth_id) && auth()->check()) {
                $model->auth_id = auth()->id();
            }


            if (is_null($model->url)) {
                $model->url = request()->fullUrl();
            }

            if (is_null($model->method)) {
                $model->method = request()->method();
            }

            if (is_null($model->model_id)) {
                $model->model_id = $model->id;
            }

            if (is_null($model->model_type)) {
                $model->model_type = get_class($model);
            }

        });

    }
}

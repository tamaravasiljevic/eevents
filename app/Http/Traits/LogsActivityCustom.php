<?php
namespace App\Http\Traits;

use App\Models\ActivityLog;
use App\Models\LogActivity;
use App\Models\User;
use App\Traits\ActivityTraits;
use Illuminate\Database\Eloquent\Model;
 use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsActivityCustom
{
    use LogsActivity;

    public static function bootLogsActivity()
    {
        static::eventsToBeRecorded()->each(function ($eventName) {
            return static::$eventName(function (Model $model) use ($eventName) {
                if (! $model->shouldLogEvent($eventName)) {
                    return;
                }

                $description = $model->getDescriptionForEvent($eventName);

                $logName = $model->getLogNameToUse($eventName);

                if ($description == '') {
                    return;
                }

                $attrs = $model->attributeValuesToBeLogged($eventName);

                if ($model->isLogEmpty($attrs) && ! $model->shouldSubmitEmptyLogs()) {
                    return;
                }

                $logger = app(ActivityLogger::class)
                    ->useLog($logName)
                    ->performedOn($model)
                    ->withProperties($attrs)->causedBy(backpack_auth()->user());

                if (method_exists($model, 'tapActivity')) {
                    $logger->tap([$model, 'tapActivity'], $eventName);
                }
                $logger->log($description);

                \App\Helpers\LogActivity::addToLog(ActivityLog::latest()->first());

            });
        });

    }
}

<?php
namespace App\Helpers;

use App\Models\ActivityLog;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Http\Request;


class LogActivity
{


    public static function addToLog(ActivityLog $activityLog)
    {
        $log = [];
        $log['url'] = request()->fullUrl();
        $log['method'] = request()->method();
        $log['ip'] = request()->ip();
        $log['agent'] = request()->header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['model_id'] = $activityLog->id;
        $log['model_type'] = get_class($activityLog);

         \App\Models\LogActivity::create($log);

    }


    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }


}

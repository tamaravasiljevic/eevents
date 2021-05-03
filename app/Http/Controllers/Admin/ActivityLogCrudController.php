<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ActivityLogRequest;
use App\Models\ActivityLog;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Activity_logCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ActivityLogCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation {
        show as traitShow;
    }


    public function setup()
    {
        $this->crud->setModel('App\Models\ActivityLog');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/activity_log');
        $this->crud->setEntityNameStrings('Activity Log', 'Activity Logs');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'label' => 'ID',
                'name'  => 'id',
                'type'  => 'text'
            ],
            [
                'name'  => 'subject_id',
                'label' => 'Entity ID',
                'type'  => 'text'
            ],
            [
                'name'  => 'subject_type_name',
                'label' => 'Entity Type',
                'type'  => 'text'
            ],
            [
                'name'  => 'description',
                'label' => 'Description',
                'type'  => 'text'
            ],
            [
                'name'  => 'caused_by',
                'label' => 'Caused By',
                'type'  => 'text'
            ],
            [
                'name'  => 'updated_at',
                'label' => 'Last modification at',
                'type'  => 'datetime'
            ],
        ]);

        $this->crud->addFilter(
            [
                'name' => 'subject_type',
                'type' => 'select2',
                'label' => 'Entity type'
            ],
            function () {
                return ActivityLog::pluck('subject_type')->unique()
                    ->mapWithKeys(function ($item) {
                        return [$item => explode("\\", $item)[2]];
                    })->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'subject_type', $value);
            }
        );
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumns([
            [
                'label' => 'ID',
                'name'  => 'id',
                'type'  => 'text'
            ],
            [
                'name'  => 'subject_id',
                'label' => 'Entity ID',
                'type'  => 'text'
            ],
            [
                'name'  => 'subject_type_name',
                'label' => 'Entity Type',
                'type'  => 'text'
            ],
            [
                'name'  => 'description',
                'label' => 'Description',
                'type'  => 'text'
            ],
            [
                'name'  => 'caused_by',
                'label' => 'Caused By',
                'type'  => 'text'
            ],
            [
                'name'  => 'created_at',
                'label' => 'Entry created at',
                'type'  => 'datetime'
            ],
            [
                'name'  => 'updated_at',
                'label' => 'Entry updated at',
                'type'  => 'datetime'
            ],
            [
                'name'  => 'properties',
                'label' => 'Changes',
                'type'  => 'json'
            ],
        ]);
    }

    public function show($id)
    {
        $content = $this->traitShow($id);

        $this->showAdditionalData($id);
        return $content;
    }

    private function showAdditionalData($id)
    {
        $content = $this->traitShow($id);
        $additionalData = $content->entry->logActivityAdditional;

        if($additionalData) {
            $this->crud->addColumns([
                [
                    'name'  => 'logActivityAdditional.ip_address',
                    'label' => 'Ip address',
                    'type'  => 'text'
                ],
                [
                    'name'  => 'logActivityAdditional.user_agent',
                    'label' => 'User agent',
                    'type'  => 'textarea',
                    'limit' => 500,
                ],
                [
                    'name'  => 'logActivityAdditional.method',
                    'label' => 'Action',
                    'type'  => 'text'
                ],
                [
                    'name'  => 'logActivityAdditional.url',
                    'label' => 'Url',
                    'type'  => 'text'
                ],
            ]);
        }
    }
}

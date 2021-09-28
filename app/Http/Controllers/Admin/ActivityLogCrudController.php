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
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow; }


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
        $entry = $this->crud->entry;
        $oldValues  = array_filter($entry->properties['old']) ?? null;
        $newValues  = array_filter($entry->properties['attributes']) ?? null;
        $changed    = array_diff($oldValues, $newValues);
        ksort($oldValues);
        ksort($newValues);
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
                    'type'  => 'textarea'
                ],
            ]);
            $oldColumns = [];
            foreach ($oldValues as $key => $value) {
                $name = 'properties.old.' . $key;
                $oldColumns[] = [
                    'name' => $name,
                    'label' => $key . '_old',
                    'type' => 'textarea',
                    'wrapper' => [
                        'style' => array_key_exists($key, $changed) ? 'color:red' : '',
                        'class' => 'form-group col-md-3 !important'
                    ],
                    'wrapperAttributes' => [
                        'class' => 'col-md-6'
                    ]
                ];
            }

            $newColumns = [];

            foreach ($newValues as $key => $value) {
                $name = 'properties.attributes.' . $key;
                $newColumns[] = [
                    'name' => $name,
                    'label' => $key . '_new',
                    'type' => 'textarea',
                    'wrapper' => [
                        'style' =>  array_key_exists($key, $changed) ? 'color:#3DC400' : '',
                        'class' => 'form-group col-md-6 !important'
                    ],
                    'wrapperAttributes' => [
                        'class' => 'col-md-6'
                    ]
                ];
            }

            $result = array_merge($oldColumns, $newColumns);

                $price = array_column($result, 'label');
                array_multisort($price, SORT_DESC, $result);

            $this->crud->addColumns($result);
            }

    }
}

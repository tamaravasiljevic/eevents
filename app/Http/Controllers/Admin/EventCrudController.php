<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EventCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Event');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/events');
        $this->crud->setEntityNameStrings('event', 'events');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'visibility',
            'label' => 'Visibility',
            'type' => 'text'
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(EventRequest::class);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text'
            ],
            [
                'name'  => 'slug',
                'label' => 'Slug',
                'type'  => 'text'
            ],
            [
                'name'  => 'description',
                'label' => 'Description',
                'type'  => 'tinymce'
            ],
            [
                'label' => 'Company',
                'type'  => 'select',
                'name'  => 'company_id',
                'entity'    => 'company',
                'attribute' => 'name',
                'model' => 'App\Models\Company',
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Venue',
                'type'  => 'select',
                'name'  => 'venue_id',
                'entity'    => 'venue',
                'attribute' => 'name',
                'model' => 'App\Models\Venue',
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Starts at',
                'name'  => 'starts_at',
                'type'  => 'datetime',
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ],
                'allows_null' => true,
            ],
            [
                'label' => 'Ends at',
                'name'  => 'ends_at',
                'type'  => 'datetime',
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Currency',
                'name'  => 'currency',
                'type' => 'select2_from_array',
                'options' => [
                    'EUR'   => 'EUR',
                    'USD'   => 'USD'
                ],
                'allows_null' => false,
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Total Capacity',
                'name'  => 'total_capacity',
                'type' => 'number',
                'allows_null' => false,
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Visibility',
                'name'  => 'visibility',
                'type'  => 'radio',
                'inline'    => true,
                'default'   => Event::VISIBILITY_PUBLIC,
                'options'   => [
                    Event::VISIBILITY_PUBLIC    => 'Public',
                    Event::VISIBILITY_PRIVATE   => 'Private',
                    Event::VISIBILITY_DRAFT     => 'Draft'
                ],
                'allows_null' => false,
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Status',
                'name'  => 'status',
                'type'  => 'radio',
                'inline'    => true,
                'default'   => Event::STATUS_ACTIVE,
                'options'   => [
                  Event::STATUS_ACTIVE => 'Active',
                  Event::STATUS_INACTIVE => 'Inactive',
                ],
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Sold Out',
                'name'  => 'sold_out',
                'type'  => 'checkbox',
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'label' => 'Event Type',
                'name'  => 'event_type_id',
                'type'  => 'select2_from_array',
                'options'   => EventType::all()->mapWithKeys(function ($item) {
                    return [$item->id => $item->name];
                }),
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

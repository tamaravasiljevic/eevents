<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventTypeRequest;
use App\Models\EventType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class EventTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventTypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\EventType');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/event_types');
        $this->crud->setEntityNameStrings('Event Type', 'Event Types');

    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => 'ID',
                'type' => 'text'
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text'
            ],

        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(EventTypeRequest::class);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text'
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumns([
            [
                'name' => 'id',
                'label' => 'Id',
                'type' => 'text',
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
            ],
        ]);
    }
}

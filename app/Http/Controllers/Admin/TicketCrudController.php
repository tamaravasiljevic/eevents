<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TicketRequest;
use App\Models\Event;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TicketCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TicketCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Ticket');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tickets');
        $this->crud->setEntityNameStrings('ticket', 'tickets');
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
            'name' => 'event_name',
            'label' => 'Event',
            'type' => 'text'
        ]);

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(TicketRequest::class);
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text'
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'tinymce'
            ],
            [
                'label' => 'Event',
                'name'  => 'event_id',
                'type'  => 'select2_from_array',
                'options'   => Event::all()->mapWithKeys(function ($item) {
                    return [$item->id => $item->name];
                }),
                'wrapperAttributes' => [
                    'class' => 'col-md-6'
                ]
            ],
            [
                'type' => 'number',
                'name' => 'price',
                'label' => 'Price',
                    'wrapperAttributes' => [
                        'class' => 'col-md-3'
                    ]
            ],
            [
                'type' => 'number',
                'name' => 'capacity',
                'label' => 'Capacity',
                'wrapperAttributes' => [
                    'class' => 'col-md-3'
                ]
            ],
            [
                'type' => 'number',
                'name' => 'order_min',
                'label' => 'Order MIN',
                'wrapperAttributes' => [
                    'class' => 'col-md-3'
                ]
            ],
            [
                'type' => 'number',
                'name' => 'order_max',
                'label' => 'Order MAX',
                'wrapperAttributes' => [
                    'class' => 'col-md-3'
                ]
            ],
            [
                'type' => 'checkbox',
                'name' => 'sold_out',
                'default'   => false,
                'label' => 'Sold out',
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

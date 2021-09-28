<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VenueRequest;
use App\Models\Company;
use App\Models\Country;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VenueCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VenueCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Venue');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/venues');
        $this->crud->setEntityNameStrings('venue', 'venues');
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
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text'
            ],
            [
                'name'  => 'address',
                'label' => 'Address',
                'type'  => 'text'
            ],
            [
                'name'  => 'city',
                'label' => 'City',
                'type'  => 'text'
            ],
            [
                'name'  => 'country_name',
                'label' => 'Country',
                'type'  => 'text'
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(VenueRequest::class);
        $countries = Country::all()->mapWithKeys(function ($item) {
                    return [$item->id => $item->name];
                });

        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'Name',
                'type'  => 'text'
            ],
            [
                'name'  => 'address',
                'label' => 'Address',
                'type'  => 'text'
            ],
            [
                'name'  => 'city',
                'label' => 'City',
                'type'  => 'text'
            ],
            [
                'name'  => 'state',
                'label' => 'State',
                'type'  => 'text'
            ],
            [
                'label' => 'Country',
                'name'  => 'country_id',
                'type'  => 'select2_from_array',
                'options'   => $countries,
            ],
//            [
//                'name'  => 'timezone',
//                'label' => 'Timezone',
//                'type'  => 'text'
//            ],
            [
                'label' => 'Company',
                'name'  => 'company_id',
                'type'  => 'select2_from_array',
                'options'   => Company::all()->mapWithKeys(function ($item) {
                    return [$item->id => $item->name];
                }),
            ],
       ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

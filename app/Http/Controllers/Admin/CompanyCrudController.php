<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\LogActivity;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Company');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/companies');
        $this->crud->setEntityNameStrings('company', 'companies');
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
            'name' => 'email',
            'label' => 'Email',
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'phone',
            'label' => 'Phone',
            'type' => 'text'
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CompanyRequest::class);

       $this->crud->addFields([
           [
               'name'   => 'name',
               'label'  => 'Name',
               'type'   => 'text'
           ],
           [
               'name'   => 'description',
               'label'  => 'Description',
               'type'   => 'text'
           ],
           [
               'name'   => 'phone',
               'label'  => 'Phone',
               'type'   => 'text'
           ],
           [
               'name'   => 'email',
               'label'  => 'Email',
               'type'   => 'text'
           ],
           [
               'name'   => 'website',
               'label'  => 'Website',
               'type'   => 'url'
           ],
           [
               'name'   => 'facebook_url',
               'label'  => 'Facebook url',
               'type'   => 'url'
           ],
           [
               'name'   => 'instagram_url',
               'label'  => 'Instagram url',
               'type'   => 'url'
           ],
           [
               'name'   => 'linkedin_url',
               'label'  => 'LinkedIn url',
               'type'   => 'url'
           ],
           [
               'name'   => 'twitter_url',
               'label'  => 'Twitter url',
               'type'   => 'url'
           ],
       ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitStoreUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/users');
        $this->crud->setEntityNameStrings('user', 'users');
    }

    protected function setupListOperation()
    {
        // hide show button
//        $this->crud->denyAccess('show');

        // add id column
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
            'type' => 'text'
        ]);

        // add name column
        $this->crud->addColumn([
            'name' => 'first_name',
            'label' => 'First Name',
            'type' => 'text'
        ]);

        // add name column
        $this->crud->addColumn([
            'name' => 'last_name',
            'label' => 'Last Name',
            'type' => 'text'
        ]);

        // add email column
        $this->crud->addColumn([
            'name' => 'email',
            'label' => 'Email Address',
            'type' => 'email'
        ]);

        // add created at column
        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => 'Crated At',
            'type' => 'datetime'
        ]);

        // add updated at column
        $this->crud->addColumn([
            'name' => 'updated_at',
            'label' => 'Updated At',
            'type' => 'datetime'
        ]);

        // add filter by name
        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'first_name',
                'label'=> 'First Name'
            ],
            false,
            function($value) {
                $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
            }
        );

        // add filter by email
        $this->crud->addFilter(
            [
                'type' => 'text',
                'name' => 'email',
                'label'=> 'Email Address'
            ],
            false,
            function($value) {
                $this->crud->addClause('where', 'email', 'LIKE', "%$value%");
            }
        );

    }

    public function setupCreateOperation()
    {

        $this->crud->setValidation(UserRequest::class);

        $this->crud->addField([
            'name' => 'first_name',
            'type' => 'text',
            'label' =>'First name'
        ]);

        $this->crud->addField([
            'name' => 'last_name',
            'type' => 'text',
            'label' => 'Last name'
        ]);

        $this->crud->addField([
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email Address'
        ]);

        $this->crud->addField([
            'name' => 'password',
            'type' => 'password',
            'label' => 'Password'
        ]);

        $this->crud->addField([
            'name' => 'password_confirmation',
            'type' => 'password',
            'label' => 'Re-type Password'
        ]);

//        $this->crud->addField([
//            'label' => "Profile Image",
//            'name' => "profile_image",
//            'type' => 'image',
//            'upload' => true,
//            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
//        ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function update(UserRequest $request)
    {

        // Hash password before save
        if (!empty($request->password)) {
            request()->merge(['password' => \Hash::make($request->password)]);
        }

        $response = $this->traitStoreUpdate();

        return $response;
    }
}

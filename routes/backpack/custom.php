<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('users', 'UserCrudController');
    Route::crud('events', 'EventCrudController');
    Route::crud('event_types', 'EventTypeCrudController');
    Route::crud('tickets', 'TicketCrudController');
    Route::crud('companies', 'CompanyCrudController');
    Route::crud('countries', 'CountryCrudController');
    Route::crud('venues', 'VenueCrudController');

    Route::crud('activity_log', 'ActivityLogCrudController');
}); // this should be the absolute last line of this file

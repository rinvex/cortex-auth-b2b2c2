<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->middleware(['web', 'nohttpcache'])
         ->namespace('Cortex\Auth\B2B2C2\Http\Controllers\Adminarea')
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {
             Route::middleware(['can:access-adminarea'])->group(function () {

                 // Members Routes
                 Route::name('members.')->prefix('members')->group(function () {
                     Route::get('/')->name('index')->uses('MembersController@index');
                     Route::post('ajax')->name('ajax')->uses('MembersController@ajax'); // @TODO: to be refactored!
                     Route::get('import')->name('import')->uses('MembersController@import');
                     Route::post('import')->name('stash')->uses('MembersController@stash');
                     Route::post('hoard')->name('hoard')->uses('MembersController@hoard');
                     Route::get('import/logs')->name('import.logs')->uses('MembersController@importLogs');
                     Route::get('create')->name('create')->uses('MembersController@form');
                     Route::post('create')->name('store')->uses('MembersController@store');
                     Route::get('{member}')->name('show')->uses('MembersController@show');
                     Route::get('{member}/edit')->name('edit')->uses('MembersController@form');
                     Route::put('{member}/edit')->name('update')->uses('MembersController@update');
                     Route::get('{member}/logs')->name('logs')->uses('MembersController@logs');
                     Route::get('{member}/activities')->name('activities')->uses('MembersController@activities');
                     Route::get('{member}/attributes')->name('attributes')->uses('MembersController@attributes');
                     Route::put('{member}/attributes')->name('attributes.update')->uses('MembersController@updateAttributes');
                     Route::delete('{member}')->name('destroy')->uses('MembersController@destroy');
                     Route::delete('{member}/media/{media}')->name('media.destroy')->uses('MembersMediaController@destroy');
                 });

                 // Managers Routes
                 Route::name('managers.')->prefix('managers')->group(function () {
                     Route::get('/')->name('index')->uses('ManagersController@index');
                     Route::get('import')->name('import')->uses('ManagersController@import');
                     Route::post('import')->name('stash')->uses('ManagersController@stash');
                     Route::post('hoard')->name('hoard')->uses('ManagersController@hoard');
                     Route::get('import/logs')->name('import.logs')->uses('ManagersController@importLogs');
                     Route::get('create')->name('create')->uses('ManagersController@form');
                     Route::post('create')->name('store')->uses('ManagersController@store');
                     Route::get('{manager}')->name('show')->uses('ManagersController@show');
                     Route::get('{manager}/edit')->name('edit')->uses('ManagersController@form');
                     Route::put('{manager}/edit')->name('update')->uses('ManagersController@update');
                     Route::get('{manager}/logs')->name('logs')->uses('ManagersController@logs');
                     Route::get('{manager}/activities')->name('activities')->uses('ManagersController@activities');
                     Route::get('{manager}/attributes')->name('attributes')->uses('ManagersController@attributes');
                     Route::put('{manager}/attributes')->name('attributes.update')->uses('ManagersController@updateAttributes');
                     Route::delete('{manager}')->name('destroy')->uses('ManagersController@destroy');
                     Route::delete('{manager}/media/{media}')->name('media.destroy')->uses('ManagersMediaController@destroy');
                 });
             });
         });
});

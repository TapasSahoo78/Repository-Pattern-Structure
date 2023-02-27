<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    RolePermissionController
};


#Role Permission Related Routes
Route::resource('roles', RolePermissionController::class);
Route::controller(RolePermissionController::class)->group(function () {
    Route::group(['prefix' => 'role', 'as' => 'roles.'], function () {
        Route::get('assign', 'assignRole')->name('assignRole');
    });
});

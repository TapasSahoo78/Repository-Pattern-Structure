<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    RolePermissionController
};

Route::controller(RolePermissionController::class)->group(function () {
    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::put('update', 'update')->name('update');
        Route::delete('delete', 'delete')->name('delete');
    });
});

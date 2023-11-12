<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Images\AdminImagesController;
use App\Http\Controllers\Images\ListImagesController;
use App\Http\Controllers\Mails\ContactMeController;
use App\Http\Controllers\Tags\CreateTagController;
use App\Http\Controllers\Tags\ListTagsController;
use App\Http\Controllers\Upload\SaveImagesController;

Route::get('clear-cache', function () {
    Artisan::call('optimize:clear');
    return ['Application has been cleared'];
});

Route::group(['prefix' => 'store'], function () {
    Route::group(['prefix' => 'assets'], function () {
        Route::post('save-image', SaveImagesController::class)->name('storeAssetsSaveImages');
        Route::get('list', ListImagesController::class)->name('storeAssetsListImages');
        Route::post('admin', AdminImagesController::class)->name('storeAdminAssets');
    });
});

Route::group(['prefix' => 'mail', 'middleware' => 'cors'], function () {
    Route::post('contactMe', ContactMeController::class)->name('contactMe');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', LoginController::class)->name('login');
    Route::post('register', LogoutController::class)->name('logout');
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('list', ListTagsController::class)->name('listTags');
    Route::post('create', CreateTagController::class)->name('createTags');
});

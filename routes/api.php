<?php

declare(strict_types=1);

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('machines', 'API\MachinesController');
Route::apiResource('printjobs', 'API\PrintJobsController');
Route::apiResource('filamentspools', 'API\FilamentSpoolsController');
Route::apiResource('manufacturers', 'API\ManufacturersController');
Route::apiResource('products', 'API\ProductsController');

// Endpoints for meta data
Route::prefix('meta')->group(function () {
    Route::middleware(['api'])->group(function () {
        Route::get('countries', 'API\MetaDataController@countries')->name('countries.index');
        Route::get('manufacturers', 'API\MetaDataController@manufacturers')->name('manufacturers.list');
    });
});

// 3D Printer REST API
Route::prefix('printer')->group(function () {
    Route::middleware(['auth:apitoken'])->group(function () {
        Route::get('verify', 'API\PrinterController@verify');
        Route::post('monitor', 'API\PrinterController@monitor');
    });
});

Route::post('/dashboard/update/{component}', 'API\DashboardController@update');

// 3D Printer Jobs...
Route::prefix('threedprinterjobs')->group(function () {
    Route::get('/', 'API\ThreeDPrinterJobsController@index')->name('api.threedprinterjobs.index');
    Route::get('/activity', 'API\ThreeDPrinterJobsController@activity')->name('api.threedprinterjobs.activity');
    Route::get('/success_rate', 'API\ThreeDPrinterJobsController@success_rate')->name('api.threedprinterjobs.success_rate');
    Route::get('/{machineJobId}', 'API\ThreeDPrinterJobsController@show')->name('api.threedprinterjobs.show');
    Route::delete('/{machineJobId}', 'API\ThreeDPrinterJobsController@destroy')->name('api.threedprinterjobs.destroy');
    Route::patch('/{machineJobId}', 'API\ThreeDPrinterJobsController@update')->name('api.threedprinterjobs.update');
});

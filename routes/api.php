<?php

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

Route::post('login', 'Api\Device\RestAPIController@login');
Route::post('sendVerificationCode','Api\Device\RestAPIController@sendVerificationCode');
Route::post('checkVerificationCode','Api\Device\RestAPIController@checkVerificationCode');
Route::post('updateCarDates','Api\Device\RestAPIController@updateCarDates');
Route::post('updateUserInfo','Api\Device\RestAPIController@updateUserInfo');
Route::post('changePassword','Api\Device\RestAPIController@changePassword');
Route::post('resetPassword','Api\Device\RestAPIController@resetPassword');
Route::post('isAuthorized', 'Api\Device\RestAPIController@isAuthorized');
Route::get('getState/{user_id}', 'Api\Device\RestAPIController@getState');

Route::post('/car/dates','Api\Device\RestAPIController@getCarDates');

Route::post('/mobile/getUserLocation', 'Api\Device\RestAPIController@getUserLocation');

Route::post('/logout', 'Api\Device\RestAPIController@logout');

Route::post('/customer/login', 'Api\Auth\AuthController@login');
Route::get('/app/version', function() {
    return response()->ok(config('app.version'));
});

Route::get('/device/find-by-imei', 'Api\Device\LoginController@find');

Route::get('/test', 'Api\Account\SettingsController@test');
Route::get('/remove-test/{type}', 'Api\Device\ServiceController@removeData');

Route::group(['middleware' => ['BkashPayment']],function(){
  Route::post('bkash/save/payment', 'Payment\BkashPaymentController@save');
  Route::post('bkash/bill/query', 'Payment\BkashPaymentController@query');
});

Route::group(['middleware' => ['LogMiddleware']], function () {
    Route::post('getLocknEngineState', 'Api\Device\RestAPIController@getLocknEngineState')->middleware('engage');

    Route::post('/device/setup/init', 'Api\Device\SetupController@init');
    Route::post('/v2/device/setup/init', 'Api\Device\SetupController@initv2');
    Route::post('/v3/device/setup/init', 'Api\Device\SetupController@initv3');
    Route::post('/v4/device/setup/init', 'Api\Device\SetupController@initv4');
    Route::post('/device/lock/status', 'Api\Device\SetupController@status');
    Route::post('/device/midnight/diff', 'Api\Device\SetupController@midnight');
    Route::post('/device/health/store', 'Api\Health\HealthController@save');
    Route::post('/device/speed/notify', 'Api\Position\SpeedController@notify');

    Route::post('/device/consume/service', 'ServiceController@consume');

    Route::post('/device/engine/update', 'Api\Device\EngineController@update');
    Route::post('/device/engine/update/test', 'Api\Device\EngineController@test');
});


Route::group(['middleware' => ['auth:api', 'account', 'engage']], function() {
    Route::get('/poi/list', 'Api\Poi\PoiController@index');
    Route::get('/poi/check/update', 'Api\Poi\PoiController@check');

    Route::post('/customer/logout', 'Api\Auth\AuthController@logout');
    Route::post('/bind/token', 'Api\User\NotificationController@bind');

    Route::post('/test/sms', 'Test\NotificationController@sms');
    Route::post('/test/noti', 'Test\NotificationController@noti');
    Route::post('/test/one-signal', 'Test\NotificationController@onesignal');

    Route::get('/district/list', 'Api\GeoFence\DistrictController@index');
    Route::get('/thana/list/{district}', 'Api\GeoFence\ThanaController@index');
    Route::get('/fence/list/{thana}', 'Api\GeoFence\FenceController@index');
    Route::post('/fence/toggle', 'Api\GeoFence\FenceController@toggle');

    Route::get('/fence/history/{id}', 'Api\GeoFence\FenceLogController@index');
    Route::post('/fence/save', 'Api\GeoFence\FenceController@save');
    Route::post('/fence/add', 'Api\GeoFence\FenceLogController@save');
    Route::post('/fence/delete', 'Api\GeoFence\FenceController@delete');

    // Route::get('/poi/check/update/test', 'Api\Poi\PoiController@test');

    Route::get('/event/list/{car}', 'Api\Car\EventController@events');
    Route::get('/event/list/test/{car}', 'Api\Car\EventController@test');

    Route::get('/car/last/position/{id}', 'Api\Position\TrackingController@last');

    Route::get('/billing/status', 'Api\Account\BillingController@status');
    Route::get('/payment/paymentlist/{userId}','Payment\PaymentController@index');
    Route::get('/payment/due/{userId}','Payment\PaymentController@getDue');
    Route::get('/user/ref/{userId}','Payment\PaymentController@getRefNo');

    Route::get('/settings/status', 'Api\Account\SettingsController@status');
    Route::post('/settings/toggle', 'Api\Account\SettingsController@toggle');

    Route::post('/lock/status/toggle', 'Api\Device\EngineController@toggle');

    Route::get('/noti/test/{id}', 'Api\User\NotificationController@test');

    Route::get('/gas/latest/{id}', 'Service\GasController@latest');
    Route::get('/gas/history/{id}', 'Service\GasController@archive');
    Route::get('/gas/history/{id}/{days}', 'Service\GasController@history');
    Route::get('/fuel/latest/{id}', 'Service\FuelController@latest');
    Route::get('/fuel/history/{id}/{days}', 'Service\FuelController@history');
    Route::get('/fuel/history/{days}', 'Service\FuelController@archive');
    Route::get('/mileage/history/{id}', 'Service\MileageController@archive');
    Route::get('/mileage/history/{carId}/{days}', 'Service\MileageController@records');

    Route::get('/trip/report/{id}/{days}', 'Bus\TripController@report');
    Route::get('/trip/details/{id}/{day}', 'Bus\TripController@details');

    Route::post('/set/current/car', 'Api\Account\SettingsController@test');

    Route::get('/get/car/dates/{id}', 'Api\Car\CarController@dates');
    Route::post('/update/car/dates', 'Api\Car\CarController@update');
    Route::post('/update/calibration', 'Input\GasRefuelInputController@setPriceFactorByUser');
    Route::post('/fuel/calibration/input', 'Input\FuelCalibrationInputController@store');
    Route::post('/device/phone','Device\DeviceController@getPhone');
});

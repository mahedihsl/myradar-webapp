<?php

/*
|--------------------------------------------------------------------------
| Web Rout23.823415, 90.371000es
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//routes for testing purposes

Route::group(['middleware' => ['auth']], function() {
  Route::get('/testmileage', 'Test\MileageTestController@show');
  Route::get('/gasfilter', 'Test\GasFilterController@show');
  Route::get('/insertbill', 'Test\BillInsertController@populate');
});

Route::get('/', function () {
    return view('landing.welcome');
})->name('welcome');


Auth::routes();

Route::get('/enroll', 'Promotion\CampaignController@bikroy');
Route::post('/enroll/save', 'Promotion\CampaignController@enroll');

Route::post('/login', 'Auth\CustomLoginController@login');
Route::get('/forgetPassword', 'Auth\CustomLoginController@getUserName');
Route::get('/password/setNewPassword', 'Auth\CustomLoginController@setNewPassword')->name('setNewPassword');
Route::post('/password/newPassword', 'Auth\CustomLoginController@newPassword');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/car/tracking', 'Customer\PositionController@show')->name('car-tracking');
    Route::get('/car/positions/{deviceId}/{start}/{finish}/{skip}', 'Customer\PositionHistoryController@getPositions');
});

Route::get('/privacy-policy', 'HomeController@privacy');

Route::get('/test/microservice', 'Test\MicroServiceController@testGeofence');
Route::get('/test/noti', 'Test\NotificationController@noti');
Route::get('/test/sms', 'Test\NotificationController@sms');
Route::get('/test/remove', 'Test\DatabaseTestController@remove');
Route::get('/test/throttle', 'Test\DatabaseTestController@throttle');
Route::get('/test/notice', 'Promotion\NoticeController@lastMonthDue');
Route::any('/test/speed-noti', 'Test\SpeedLimitController@noti');
Route::any('/test/push-noti', 'Test\PushNotificationController@test');
Route::any('/test/engine-noti', 'Test\EngineStatusController@noti');
Route::post('/test/excel-import', 'Test\ExcelController@testImport');
Route::any('/concox/test', 'Test\ConcoxController@receive');

// Private Customer
Route::group(['middleware' => ['auth', 'role:4', 'customer:1']], function() {

    /**
     * APIs for car tracking
     */
    Route::get('/user/device/ids/{userId}', 'Customer\DeviceController@devices');

    Route::get('/refuel/log', 'Calibration\RefuelFeedController@customer')->name('refuel-feed');
    Route::post('/refuel/feed/save', 'Calibration\RefuelFeedController@store');

});

Route::get('/concox/lock/test', 'Device\ConcoxController@test');

// TODO: remove these with backwawrd check
// Private Customer API
// Route::group(['middleware' => ['querylog']], function() {
    Route::post('/api/fuelHistories', 'Api\Device\HistoryAPIController@fuel_histories');
    Route::post('/api/gasHistories', 'Api\Device\HistoryAPIController@gas_histories');
    Route::post('/api/getFuelGasLevel', 'Api\Device\HistoryAPIController@getFuelGasLevel');
    Route::get('/api/event/recent/{id}','Car\EventController@recent');
// });

// Enterprise
Route::group(['middleware' => ['auth', 'role:4', 'customer:2']], function() {
    Route::get('/enterprise/car/list/{id}', 'Enterprise\CarController@all');

    Route::get('/driver/manage', 'Enterprise\DriverController@manage')->name('drivers');
    Route::get('/driver/list/{id}', 'Enterprise\DriverController@index');
    Route::post('/driver/save', 'Enterprise\DriverController@save');
    Route::post('/driver/update', 'Enterprise\DriverController@update');
    Route::post('/driver/delete', 'Enterprise\DriverController@delete');

    Route::post('/driver/assign', 'Enterprise\AssignmentController@save');
    Route::post('/driver/assignmentList/{id}', 'Enterprise\AssignmentController@all');

    Route::get('/employee/manage', 'Enterprise\EmployeeController@manage')->name('employees');
    Route::get('/employee/list/{id}', 'Enterprise\EmployeeController@index');
    Route::post('/employee/save', 'Enterprise\EmployeeController@save');
    Route::post('/employee/update', 'Enterprise\EmployeeController@update');
    Route::post('/employee/delete', 'Enterprise\EmployeeController@delete');

    Route::get('/driving/hour', 'Enterprise\DrivingController@show')->name('driving-hour');
    Route::get('/driving/hour/sum/{id}', 'Enterprise\DrivingController@sum');
    Route::get('/driving/hour/report/{id}', 'Enterprise\DrivingController@report');
    Route::get('/driving/hour/export','Enterprise\DrivingController@export');

    Route::get('/duty/hour', 'Enterprise\DutyController@show')->name('duty-hour');
    Route::get('/duty/hour/sum/{id}', 'Enterprise\DutyController@sum');
    Route::get('/duty/hour/report/{id}', 'Enterprise\DutyController@report');
    Route::get('/duty/hour/export', 'Enterprise\DutyController@export_v2');

    Route::get('/mileage/report', 'Enterprise\MileageController@show')->name('mileage-report');
    Route::get('/mileage/sum/{id}', 'Enterprise\MileageController@sum');
    Route::get('/mileage/report/{id}', 'Enterprise\MileageController@report');
    Route::get('/mileage/export', 'Enterprise\MileageController@export');

    Route::get('/tail/report', 'Enterprise\TailController@show')->name('tail-report');

    Route::get('/text/tracker', 'Enterprise\TextTrackerController@show')->name('text-tracker');

    Route::get('/map/search', 'Enterprise\MapController@show')->name('map-search');
    Route::get('/zone/car/list/{id}', 'Enterprise\MapController@cars');
    Route::get('/car/current/assignment/{id}', 'Enterprise\AssignmentController@current');

    Route::get('/text/tracker', 'Enterprise\TextTrackerController@show')->name('text-tracker');
    Route::get('/text/text-tracker/location/list/{carId}','Enterprise\TextTrackerController@locations' );
    Route::get('/text/text-tracker/car/list/{userId}','Enterprise\VehicleController@all')->name('text-tracker-car-list');
    Route::get('/text/text-tracker/thana/list/{district}','Enterprise\TextTrackerController@thanalist');
    Route::get('/text/driver/assignment/info/{driverId}','Enterprise\TextTrackerController@assignmentInfo');

    Route::get('/enterprise/car/tracking', 'Car\TrackingController@show');
    Route::get('/enterprise/car/route/{id}', 'Enterprise\TrackingController@route');

    Route::get('/enterprise/settings', 'Enterprise\SettingsController@show')->name('enterprise-settings');
    Route::get('/enterprise/settings/{userId}/{carId}', 'Enterprise\SettingsController@view');
    Route::post('/enterprise/settings/change', 'Enterprise\SettingsController@change');

    Route::get('enterprise/fence/list/{id}', 'Api\GeoFence\FenceController@enterpriseIndex');
    Route::post('/fence/save', 'Api\GeoFence\FenceController@save');
    Route::post('/fence/delete', 'Api\GeoFence\FenceController@delete');
});

// Admin
Route::group(['middleware' => ['auth', 'role:1']], function() {
    Route::get('/users', 'User\UserController@index');
    Route::get('/user/details/{id}', 'User\UserController@show');
    Route::get('/user/create', 'User\UserController@create');
    Route::post('/user/save', 'User\UserController@save');
    Route::get('/user/edit/{id}', 'User\UserController@edit');
    Route::post('/user/update', 'User\UserController@update');
    Route::get('/user/activate/{id}', 'User\UserController@activate');
    Route::get('/user/deactivate/{id}', 'User\UserController@deactivate');

    Route::get('/bill/entry', 'Finance\BillingController@entry');
    Route::get('/billing/report', 'Admin\BillingController@index');
    Route::get('/billing/export', 'Admin\BillingController@export');
    Route::get('/billing/drilldown', 'Admin\BillingController@drilldown');
    Route::get('/activation/report', 'Admin\ActivationController@index')->name('activation.report');
    Route::post('/activation/export', 'Admin\ActivationController@export');
    Route::post('/activation/batch/disable', 'Admin\ActivationController@batchDisable');

    Route::get('/devices', 'Device\DeviceController@index')->name('devices');
    Route::get('/device/newid', 'Device\DeviceController@generateId');
    Route::get('/device/bind/history', 'Device\DeviceController@bindHistory')->name('bind.history');
    Route::post('/device/create', 'Device\DeviceController@save');
    Route::get('/devices/recent/{skip}', 'Device\DeviceController@recent');
    Route::get('/devices/print/recent', 'Device\DeviceController@print');
    Route::get('/devices/export','Device\DeviceController@export');
    Route::post('/device/update/version', 'Device\DeviceController@updateVersion');

    Route::get('/bus/routes', 'Bus\RouteController@index');
    Route::get('/bus/company/names', 'Bus\RouteController@companies');
    Route::get('/bus/list/{id}', 'Bus\RouteController@buses');
    Route::post('/bus/route/save', 'Bus\RouteController@save');
    Route::post('/bus/route/delete', 'Bus\RouteController@delete');

    Route::get('/payment/message','Payment\PaymentController@sendAll');
    Route::get('/payment/method/sms','Payment\PaymentController@sendMethodAll');

    Route::get('/promotion','Promotion\PromotionController@index');
    Route::post('/save/scheme','Promotion\PromotionController@save');
    Route::get('/customer/ids','User\CustomerController@getIds');

    Route::get('/due/notice', 'Promotion\NoticeController@dueNotice')->name('due-notice');
    Route::post('/send/single/notice', 'Promotion\NoticeController@sendSingleNotice');
    Route::post('/send/due/notice', 'Promotion\NoticeController@sendDueNotice');
    Route::get('/export/due/notice/{via}', 'Promotion\NoticeController@exportDueNotice');
});

//int ops
Route::group(['middleware' => ['auth', 'role:3']], function() {
    Route::post('/service/api/get_service_diagnosis', 'Service\ServiceApiController@get_service_diagnosis');

    Route::get('/service-monitor', 'ServiceMonitor\ServiceMonitorController@show');
    Route::get('/user/devices/{id}', 'Device\DeviceController@allOfUser');

    Route::post('/device/update/phone', 'Device\DeviceController@changePhone');

    Route::get('/services/api', 'Service\ServiceApiController@index');
    Route::post('/services/api/update', 'Service\ServiceApiController@update');

    Route::get('/service/log/{car}/{service}', 'Service\ServiceLogController@history');
    Route::get('/service/report/{car_id}', 'Service\ServiceLogController@report');

    Route::get('/fuel/calibration/log/{id}', 'Calibration\FuelCalibrationController@index');
    Route::get('/user/fuel/calibration/log/{id}', 'Input\FuelCalibrationInputController@userData');
    Route::post('/fuel/calibration/save', 'Calibration\FuelCalibrationController@store');
    Route::post('/fuel/calibration/delete', 'Calibration\FuelCalibrationController@remove');

    Route::get('/gas/calibration/log/{id}', 'Calibration\GasCalibrationController@index');
    Route::get('/gas/calibration/min/{id}', 'Calibration\GasCalibrationController@getGasMin');
    Route::get('/gas/calibration/min/save/{carId}/{gasMin}','Calibration\GasCalibrationController@setGasMin');
    Route::post('/gas/calibration/save', 'Calibration\GasCalibrationController@store');
    Route::post('/gas/calibration/delete', 'Calibration\GasCalibrationController@remove');
    Route::get('/gas/refuel/input/{id}', 'Calibration\GasCalibrationController@refuelInput');

    Route::get('/car/meta-data/find/{id}', 'Calibration\MetaDataController@show');
    Route::get('/car/meta-data/find/price/tune/{id}', 'Calibration\MetaDataController@showpricetune');
    Route::post('/car/meta-data/update', 'Calibration\MetaDataController@update');
    Route::post('/car/meta-data/tune/update', 'Calibration\MetaDataController@updatepricetune');

    Route::get('/vehicles', 'Car\CarController@index');
    Route::get('/vehicles/search', 'Car\CarController@search');
    Route::get('/vehicles/export', 'Car\CarController@export');

    Route::get('unhealthy/device', 'Device\PerformanceController@unhealthy');

});

// customer care
Route::group(['middleware' => ['auth', 'role:2']], function() {
    Route::get('/payment/paymentlist/{userId}','Payment\PaymentController@index');
    Route::get('/payment/message/{userId}','Payment\PaymentController@getMsgContent');
    Route::get('/payment/total-due/{userId}','Payment\PaymentController@totalDue');
    Route::post('/payment/sms/send', 'Payment\PaymentController@send');
    Route::get('/payment/method/sms/{userId}','Payment\PaymentController@sendMethod');
    Route::post('/save/payment', 'Payment\PaymentController@save');
    Route::get('/get/payments/{userId}','Payment\PaymentController@getPayments');

    Route::post('/promotion/sms','Promotion\PromotionController@message');
    Route::post('/promotion/notification','Promotion\PromotionController@notification');
    Route::get('/promotion/schemelist','Promotion\PromotionController@show');
    Route::get('/promo/code/list','Promotion\PromoCodeController@show');
    Route::get('/generate/promo','Promotion\PromoCodeController@generate');
    Route::post('/save/promo','Promotion\PromoCodeController@save');

    Route::get('/billing', 'Account\BillingController@index')->name('billing');
    Route::post('/importExcel', 'Account\BillingController@importExcel');

    Route::get('/find/customer/{phone}', 'User\CustomerController@findByPhone');

    Route::get('/customers', 'User\CustomerController@index')->name('all-customers');
    Route::post('/customer/save', 'User\CustomerController@save');
    Route::post('/customer/update', 'User\CustomerController@update');
    Route::post('/customer/password/change', 'User\CustomerController@password');
    Route::get('/customer/toggle-history/{id}', 'User\CustomerController@toggleHistory');

    Route::get('/customer/settings/{id}', 'Api\Account\SettingsController@view');
    Route::post('/customer/settings/change', 'Api\Account\SettingsController@change');

    Route::get('/messages', 'Contact\MessageController@index');

    Route::get('/car/speed-limit/get/{id}', 'Car\SpeedController@show');
    Route::post('/car/speed-limit/update', 'Car\SpeedController@update');

    Route::post('/zone/save', 'Enterprise\ZoneController@store');
    Route::post('/zone/delete', 'Enterprise\ZoneController@delete');

    Route::get('/share/user/search', 'Enterprise\ShareController@search');
    Route::get('/share/shared/users', 'Enterprise\ShareController@shared');
    Route::post('/share/provide/access', 'Enterprise\ShareController@provide');
    Route::post('/share/revoke/access', 'Enterprise\ShareController@revoke');

    Route::get('/leads', 'Promotion\CampaignController@leads');

    Route::get('/activity/login/stats/{id}', 'Admin\EngagementController@login');
    Route::get('/activity/request/stats/{id}', 'Admin\EngagementController@request');

    Route::get('/engagement/report', 'Admin\EngagementController@index');
    Route::get('/engagement/export', 'Admin\EngagementController@export');
});

Route::post('/message/save', 'Contact\MessageController@store')->name('save-message');

Route::get('/fuel/latest/{id}', 'Service\FuelController@latest');
Route::get('/fuel/history/{id}/{day}', 'Service\FuelController@history');
Route::get('/gas/latest/{id}', 'Service\GasController@latest');
Route::get('/gas/history/{id}/{day}', 'Service\GasController@history');

Route::post('/customers/add/api', 'User\CustomerApiController@add');//int-ops
Route::post('/customers/delete/api', 'User\CustomerApiController@delete');//int-ops
Route::post('/customers/sendCredential/api', 'User\CustomerApiController@sendCredential');//int-ops
Route::post('/bind-services/api', 'Service\ServiceApiController@bindWithComId');//int-op

Route::get('/customer/vehicles/{id}', 'Customer\PositionController@show');
Route::get('/customer/vehicles/positions/{id}', 'Customer\PositionController@devices');

Route::get('/user/car/names/{userId}', 'Customer\DeviceController@cars');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/customers/api', 'User\CustomerApiController@index');
    Route::get('/customer/types/api', 'User\CustomerApiController@types');
    Route::get('/customer/info/{id}', 'Customer\ManageController@info');
    Route::get('/manage/customer/{id}', 'User\CustomerController@manage')->name('manage.customer');
    Route::get('/service/view', 'Customer\ServiceController@show')->name('service-view');

    // AJAX API
    Route::get('/user/account/info/{id}', 'Customer\AccountController@info');
    Route::post('/user/account/toggle', 'Customer\AccountController@toggle');
    Route::get('/user/car/list/{id}', 'Car\CarController@all');

    Route::get('/car/details/{id}', 'Car\CarController@show');
    Route::post('/car/save', 'Car\CarController@save');
    Route::post('/car/update', 'Car\CarController@update');

    Route::get('/car/state/{id}', 'Car\DeviceController@state');
    Route::get('/car/packages', 'Car\CarController@packages');
    Route::get('/car/services/{id}', 'Car\CarController@services');
    Route::get('/car/toggle-status/{id}', 'Car\CarController@toggleStatus');

    Route::post('/car/bind/device', 'Car\DeviceController@bind');
    Route::post('/car/unbind/device', 'Car\DeviceController@unbind');
    Route::get('/service/data/status/{cid}/{sid}', 'Car\DeviceController@status');

    Route::post('/bind/token', 'Api\User\NotificationController@bind');
    Route::post('/check/subscription','Api\User\NotificationController@checkSubscription');
    // END

    Route::get('/mileage/records/{carId}/{days}', 'Service\MileageController@records');

    Route::get('/geofence/manage/{id}', 'Fence\AreaController@index')->name('area-fence');
    Route::post('/geofence/save', 'Fence\AreaController@save');
    Route::post('/geofence/subscribe', 'Fence\AreaController@subscribe');
    Route::post('/geofence/unsubscribe', 'Fence\AreaController@unsubscribe');
    Route::get('/geofence/fetch', 'Fence\AreaController@fetch');
    Route::get('/geofence', 'Fence\FenceController@index');
    
    Route::get('/get/fence/log', 'Fence\FenceLogController@index');
    Route::get('/district/list', 'Fence\DistrictController@index');
    Route::get('/thana/list/{district}', 'Fence\ThanaController@index');
    Route::get('/fence/list/{thana}', 'Fence\FenceController@items');
    Route::post('/fence/toggle', 'Fence\FenceController@toggle');

    Route::get('/refuel/feed/log/{id}/{type?}', 'Calibration\RefuelFeedController@all');
    Route::get('/customer/data/{id}', 'User\CustomerApiController@info');
    Route::get('/customer/access/of/user', 'Account\AccessController@customer');
    Route::get('/message/access/of/user', 'Account\AccessController@messageAccess');

    Route::get('/change/password', 'Auth\PasswordChangeController@change');
    Route::post('/change/password', 'Auth\PasswordChangeController@reset');

    Route::get('/device/status/{id}', 'Api\Device\EngineController@status');
    Route::post('/lock/status/toggle', 'Api\Device\EngineController@toggle');

    Route::get('/event/list/{id}', 'Car\EventController@index');
    Route::get('/car/last/position/{deviceId}', 'Customer\PositionHistoryController@getLastPosition');

    Route::get('/zone/list/{id}', 'Enterprise\ZoneController@index');

    Route::get('/performance', 'Device\PerformanceController@index');
    Route::get('/performance/stats', 'Device\PerformanceController@stats');
    Route::get('/performance/items', 'Device\PerformanceController@items');

    Route::get('/lastpulse', 'Device\LastPulseController@index');
    Route::get('/lastpulse/stats', 'Device\LastPulseController@stats');
    Route::get('/lastpulse/items', 'Device\LastPulseController@items');
    Route::post('/lastpulse/update', 'Device\LastPulseController@update');

    Route::get('/complains', 'ServiceMonitor\ComplainController@index');
    Route::post('/save/complain', 'ServiceMonitor\ComplainController@save');
    Route::get('/complain/list', 'ServiceMonitor\ComplainController@all');
    Route::get('/complain/export', 'ServiceMonitor\ComplainController@export');
    Route::get('/complain/search', 'ServiceMonitor\ComplainController@search');
    Route::post('/complain/add/comment', 'ServiceMonitor\ComplainController@change');
});

Route::get('/tracking/report', 'Report\TrackingController@report');
Route::get('/report/positions', 'Report\PositionController@show');
Route::get('/report/positions/fetch', 'Report\PositionController@latest');

Route::get('/tracking/history/{id}', 'Customer\PositionHistoryController@show');
Route::get('/tracking/records/fetch', 'Customer\PositionHistoryController@history');

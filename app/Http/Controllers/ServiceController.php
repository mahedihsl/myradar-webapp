<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\ServiceStringReceived;
use App\Events\ExternalDeviceDataReceived;
use App\Criteria\CommercialIdCriteria;
use App\Generator\ServiceConsumerGenerator;
use App\Contract\Repositories\DeviceRepository;
use App\Entities\ExecTime;
use App\Entities\Device;
use GuzzleHttp\Client;

class ServiceController extends Controller
{
	/**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function consume(Request $request)
    {
		$start = round(microtime(true) * 1000);
		$com_id = intval($request->get('ss'));
		$device = Device::raw(function($collection) use ($com_id) {
			return $collection->findOne([
				'com_id' => ['$eq' => $com_id]
			]);
		});

        if ( ! is_null($device)) {

	    try {
            	$generator = new ServiceConsumerGenerator($device, collect($request->all()));
            	$count = $generator->apply();
            	event(new ServiceStringReceived($device, $count));
	    } catch(\Exception $e) {
	    
	    }

			try {
				// $test_devices = [40701];
				// in_array(intval($request->get('ss')), $test_devices)
				$client_id = '5e20848391c4040013599f60'; // Jatri App
				if ($device->user_id == $client_id) {
					event(new ExternalDeviceDataReceived($device, $request->all()));
				}
			} catch (\Exception $e) {
				Log::info('Jatri data exception', [
					'msg' => $e->getMessage(),
				]);
			}

			try {
				$end = round(microtime(true) * 1000);
				ExecTime::create([
					'device' => $com_id,
					'time' => $end - $start,
				]);
			} catch (\Exception $e) {
				//throw $th;
			}

            return strval($device->lock_status);
        }

        return '-1';
    }

	// public function external($request)
	// {
	// 	$client = new Client();
	// 	$response = $client->request('POST', 'http://45.64.135.28/api/test/device/receive', [
	// 		'form_params' => [
	// 			'protocol' => 1,
	// 			'data' => $request->all(),
	// 		]
	// 	]);
	//
	// 	return $response->getBody();
	// }
}

<?php

namespace App\Http\Controllers\Api\Device;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Entities\Device;
use Vinkla\Pusher\Facades\Pusher;

use App\Service\PusherService;
use App\Criteria\CommercialIdCriteria;
use App\Contract\Repositories\DeviceRepository;

use App\Events\EngineStatusChanged;
use App\Events\LockWhenEngineOnEvent;
use App\Events\LockWhenEngineOffEvent;
use App\Events\UnlockWhenEngineOnEvent;
use App\Events\UnlockWhenEngineOffEvent;
use Carbon\Carbon;


class EngineController extends Controller
{
    /**
     * @var DeviceRepository
     */
    private $repository;

    public function __construct(DeviceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function status(Request $request, $id)
    {
        $device = $this->repository->find($id);

        if ( ! is_null($device)) {
            return response()->ok([
                'lock' => $device->lock_status,
                'engine' => $device->engine_status,
            ]);
        }

        return response()->error('Device not Found');
    }

    public function toggle(Request $request)
    {
        $user = $request->user('api');
        if(is_null($user)){
          $user = $request->user();
        }
        if ($user->demo) {
            return response()->error('No Real Car !');
        }

        $target_lock = intval($request->get('lock_status'));
        $device = $this->repository->find($request->get('device_id'));

        if (!$device->car->status) {
            return response()->error('Car is not active');
        }

        if ( ! is_null($device)) {
            if(!$user->isSharedCar($device->car_id)){
              if ($device->engine_status === 1) {
                  if ($target_lock === 1) {
                      event(new LockWhenEngineOnEvent($device));
                  } else {
                      event(new UnlockWhenEngineOnEvent($device));
                  }
              } else {
                  if ($target_lock === 1) {
                      event(new LockWhenEngineOffEvent($device));
                  } else {
                      event(new UnlockWhenEngineOffEvent($device));
                  }
              }

              return response()->ok([
                  'lock_status' => $device->lock_status,
              ]);
            }

        }
        return response()->error();
    }

    public function update(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $device = $this->repository->skipPresenter()->pushCriteria($criteria)->first();

        if ( ! is_null($device)) {
            $status = intval($request->get('status'));
            event(new EngineStatusChanged($device, $status));
            if ($status == 0) {
                $device->update([
                    'engine_status' => $status,
                    'off_by' => 'device',
                ]);
                $notify = new PusherService();
                $notify->onEngineOff($device);
                return '2';
            } else {
                $device->update([
                    'engine_status' => $status,
                    'last_start' => Carbon::now(),
                ]);
                return '1';
            }
        }

        return '0';
    }

    public function test(Request $request)
    {
        $criteria = new CommercialIdCriteria($request->get('com_id'));
        $device = $this->repository->skipPresenter()->pushCriteria($criteria)->first();
        $user = $device->user;

        $data = [
            'engine_status' => $device->engine_status,
            'lock_status' => $device->lock_status,
        ];
        Pusher::trigger('map-channel-'.$user->id, 'engine-off-event', [
            'message' => $data
        ]);

        return $res;
    }

}

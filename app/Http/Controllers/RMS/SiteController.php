<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Http\Requests\CreateRmsSite;
use App\Http\Requests\UpdateRmsSite;
use App\Service\Microservice\DeviceMicroservice;
use App\Service\Microservice\RMSUserMicroservice;

class SiteController extends Controller
{
    private $rmsUserService;
    private $deviceService;

    public function __construct()
    {
        $this->deviceService = new DeviceMicroservice();
        $this->rmsUserService = new RMSUserMicroservice();
    }

    public function index(Request $request)
    {
        $sites = $this->rmsUserService->filterSites($request->all());
        return response()->json($sites);
    }

    public function create(Request $request)
    {
        return view('rms_site.create')->with([
            'user' => User::find($request->user_id),
        ]);
    }

    public function save(CreateRmsSite $request)
    {
        $res = $this->rmsUserService->saveSite($request->all());
        // $redirectUrl = '/rms/site/manage?user_id=' . $request->get('user_id');
        // return redirect($redirectUrl);
        return response()->json($res);
    }

    public function edit(Request $request, $id)
    {
        $filteredSites = $this->rmsUserService->filterSites(['id' => $id]);
        return view('rms_site.edit')->with([
            'site' => $filteredSites[0],
        ]);
    }

    public function update(UpdateRmsSite $request)
    {
        $res = $this->rmsUserService->updateSite($request->all());
        // $redirectUrl = '/rms/site/manage?user_id=' . $request->get('user_id');
        // return redirect($redirectUrl);
        return response()->json($res);
    }

    public function bind(Request $request)
    {
        $res = $this->deviceService->bindWithSite($request->all());
        return response()->json($res);
    }

    public function unbind(Request $request)
    {
        $res = $this->deviceService->unbindFromSite($request->all());
        return response()->json($res);
    }

    public function configure(Request $request, $id)
    {
        $filteredSites = $this->rmsUserService->filterSites(['id' => $id]);
        $site = $filteredSites[0];

        return view('rms_site.configure')->with([
            'site' => $site,
        ]);
    }

    public function siteInfo(Request $request)
    {
        $id = $request->get('site_id');
        $filteredSites = $this->rmsUserService->filterSites(['id' => $id]);

        return response()->json($filteredSites[0]);
    }

    public function fetchPinConfig(Request $request)
    {
        $config = $this->deviceService->getRmsPinConfig($request->all());
        return response()->json($config);
    }

    public function savePinConfig(Request $request)
    {
        $res = $this->deviceService->saveRmsPinConfig($request->all());
        return response()->json($res);
    }

    public function updatePinConfig(Request $request)
    {
        $res = $this->deviceService->updateRmsPinConfig($request->all());
        return response()->json($res);
    }

    public function removePinConfig(Request $request)
    {
        $res = $this->deviceService->removeRmsPinConfig($request->all());
        return response()->json($res);
    }

    public function cacheSiteStatus(Request $request)
    {
        $res = $this->rmsUserService->cacheSiteStatus($request->all());
        return response()->json($res);
    }

    public function statusCounts(Request $request)
    {
        $user_id = $request->get('user_id');
        $res = $this->rmsUserService->statusCounts(compact('user_id'));
        return response()->json($res);
    }

    public function getDigitalControl(Request $request)
    {
        $res = $this->rmsUserService->getSiteDigitalControl($request->all());
        return response()->json($res);
    }

    public function setDigitalControl(Request $request)
    {
        $res = $this->rmsUserService->setSiteDigitalControl($request->all());
        return response()->json($res);
    }
}

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

    public function __construct() {
      $this->deviceService = new DeviceMicroservice();
      $this->rmsUserService = new RMSUserMicroservice();
    }

    public function index(Request $request)
    {
      $user = User::find($request->user_id);
      if (!$user) {
        throw new \Exception('Customer not found');
      }

      $query = ['user_id' => $user->id];
      $sites = $this->rmsUserService->filterSites($query);

      return view('rms_site.index')->with([
        'user' => $user,
        'sites' => $sites,
      ]);
    }

    public function create(Request $request)
    {
      return view('rms_site.create')->with([
        'user' => User::find($request->user_id),
      ]);
    }

    public function save(CreateRmsSite $request)
    {
      $this->rmsUserService->saveSite($request->all());
      $redirectUrl = '/rms/site/manage?user_id=' . $request->get('user_id');
      return redirect($redirectUrl);
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
      $this->rmsUserService->updateSite($request->all());
      $redirectUrl = '/rms/site/manage?user_id=' . $request->get('user_id');
      return redirect($redirectUrl);
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
}

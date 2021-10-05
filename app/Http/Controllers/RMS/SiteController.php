<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\User;
use App\Service\Microservice\RMSUserMicroservice;

class SiteController extends Controller
{
    private $rmsUserService;

    public function __construct() {
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
      return view('rms_site.create');
    }

    public function save(Request $request)
    {
      
    }
    
    public function edit(Request $request)
    {
      return view('rms_site.edit');
    }

    public function update(Request $request)
    {
      
    }
}

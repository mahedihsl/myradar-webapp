<?php

namespace App\Http\Controllers\RMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    public function index(Request $request)
    {
      $user = User::find($request->user_id);
      if (!$user) {
        throw new \Exception('Customer not found');
      }

      return view('rms_site.index')->with([
        'user' => $user,
      ]);
    }
}

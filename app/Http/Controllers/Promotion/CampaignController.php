<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Enroll;

class CampaignController extends Controller
{
    public function bikroy(Request $request)
    {
        return view('promotion.bikroy')->with([
            'status' => 0,
        ]);
    }

    public function eheater(Request $request)
    {
        return view('promotion.eheater')->with([
            'status' => 0,
        ]);
    }

    public function enroll(Request $request)
    {
        Enroll::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'type' => $request->get('type', 'general_lead'),
        ]);

        return redirect()->back()->with([
            'status' => 1,
        ]);
    }

    public function leads(Request $request)
    {
        return view('promotion.leads')->with([
            'leads' => Enroll::orderBy('created_at', 'desc')->paginate(),
        ]);
    }
}

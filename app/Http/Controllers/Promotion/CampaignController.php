<?php

namespace App\Http\Controllers\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Enroll;
use App\Service\Microservice\PromotionMicroservice;

class CampaignController extends Controller
{
    private $promotionService;

    public function __construct() {
        $this->promotionService = new PromotionMicroservice();
    }

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
        $status = 1;
        try {
            $this->promotionService->saveLead($request->all());
        } catch (\Throwable $th) {
            $status = 0;
        }

        if ($request->ajax()) {
            return response()->ok('Message Sent');
        }

        return redirect()->back()->with([
            'status' => $status,
        ]);
    }

    public function leads(Request $request)
    {
        $query = Enroll::orderBy('created_at', 'desc');
        if ($request->type) {
            $query = $query->where('type', $request->type);
        }
        return view('promotion.leads')->with([
            'leads' => $query->paginate(),
        ]);
    }
}

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
        try {
            $this->promotionService->saveLead($request->all());
            return response()->ok('আপনার রেজিস্ট্রেশন সম্পন্ন হয়েছে, আপনাকে একটি ডিসকাউন্ট কোড সহ শীঘ্রই এসএমএস করে জানানো হবে');
        } catch (\Exception $th) {
            return response()->error($th->getMessage());
        }
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

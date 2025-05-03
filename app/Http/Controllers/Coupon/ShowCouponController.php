<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Exception;
class ShowCouponController extends Controller
{
    //
    public function index()
    {
        try {
            $coupons = Coupon::all();

            return response()->json([
                'coupons' => $coupons,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve coupons',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

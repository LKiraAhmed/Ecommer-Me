<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;

class AddCouponController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|unique:coupons,code',
                'discount_amount' => 'required|numeric|min:0',
                'expires_at' => 'nullable|date|after:today',
            ]);

            $coupon = Coupon::create([
                'code' => $validated['code'],
                'discount_amount' => $validated['discount_amount'],
                'expires_at' => $validated['expires_at'] ?? null,
            ]);

            return response()->json([
                'message' => 'Coupon created successfully',
                'coupon' => $coupon,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to create coupon',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

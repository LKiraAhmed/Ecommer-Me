<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Exception;
class EditCouponController extends Controller
{
    //
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:coupons,id',
                'code' => 'required|unique:coupons,code,' . $request->id,
                'discount_amount' => 'required|numeric|min:0',
                'expires_at' => 'nullable|date|after:today',
            ]);

            $coupon = Coupon::findOrFail($validated['id']);

            $coupon->update([
                'code' => $validated['code'],
                'discount_amount' => $validated['discount_amount'],
                'expires_at' => $validated['expires_at'] ?? null,
            ]);

            return response()->json([
                'message' => 'Coupon updated successfully',
                'coupon' => $coupon,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to update coupon',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

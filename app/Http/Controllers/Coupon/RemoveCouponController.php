<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Exception;
class RemoveCouponController extends Controller
{
    //
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:coupons,id',
            ]);

            $coupon = Coupon::findOrFail($request->id);
            $coupon->delete();

            return response()->json([
                'message' => 'Coupon deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to delete coupon',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

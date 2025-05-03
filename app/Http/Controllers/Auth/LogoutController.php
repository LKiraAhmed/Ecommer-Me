<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; 
class LogoutController extends Controller
{
    //
    public function logout()
    {
        Auth::guard('user')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}

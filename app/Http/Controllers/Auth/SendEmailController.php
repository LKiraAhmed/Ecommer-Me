<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
class SendEmailController extends Controller
{
    //
    public function index(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = User::where('email', $request->email)->first();
        $token = JWTAuth::fromUser($user);
     //   Mail::to($user->email)->send(new SendMail($user, $token));
     Mail::raw("Click the link to reset your password: " . url("/api/password/reset?token=$token"), function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Password Reset');
    });
    return response()->json(['message' => 'Reset link sent to your email.']);

    }
}

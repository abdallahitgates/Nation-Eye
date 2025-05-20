<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\smsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class AuthController extends Controller
{
    public function __construct(private readonly smsService $smsService) {}
    
    
    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'national_id' => 'required',
            'phone' => 'required',
        ]);

        $user = User::firstOrCreate([
            'national_id' => $data['national_id'],
            'phone' => $data['phone'],
        ]);

        $otp = rand(1000, 9999);
        $message = "Your OTP code is: $otp. Please do not share it with anyone.";
        $this->smsService->sendSms($user->phone, $message);

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        return response()->json(['message' => __('messages.otp_sent')]);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required',
            'otp' => 'required',
        ]);

        $user = User::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return response()->json(['message' => __('messages.otp_invalid')], 401);
        }

        // Clear OTP after successful verification
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        // Generate Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => __('messages.otp_verified'),
            'token' => $token,
            'user' => $user,
        ]);
    }
}

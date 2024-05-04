<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Jobs\SendSmsToAuth;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(AuthRequest $authRequest): JsonResponse
    {

        $user = User::where('phone_number',$authRequest->authAllowedInputs()['phoneNumber'])->first();

        if ($user) {
            return response()->json([
                'status' => 200,
                'message' => 'user is registered'
            ]);
        }

        $user = User::create([
            'phone_number' => $authRequest->authAllowedInputs()['phoneNumber']
        ]);

        $otpCode = rand(111111, 999999);

        if (env('APP_ENV') !== 'production') {
            $otpCode = 111111;
        }

        $otpInputs = [
            'user_id' => $user->id,
            'otp_code' => $otpCode
        ];

        $otp = Otp::create($otpInputs);

        SendSmsToAuth::dispatch($otp);



        return response()->json([
            'status' => 200,
            'message' => 'User registered go verify page',
            'data' => [
                'user_id' => $user->id
            ]
        ]);

    }

    public function login(AuthRequest $authRequest): JsonResponse
    {
        $user = User::where('phone_number',$authRequest->authAllowedInputs()['phoneNumber'])->first();

        if (!$user) {
            return response()->json([
                'status' => 200,
                'message' => 'user is not registered'
            ]);
        }

        $otpCode = rand(111111, 999999);

        if (env('APP_ENV') !== 'production') {
            $otpCode = 111111;
        }

        $otpInputs = [
            'user_id' => $user->id,
            'otp_code' => $otpCode
        ];

        $otp = Otp::create($otpInputs);

        SendSmsToAuth::dispatch($otp);

        return response()->json([
            'status' => 200,
            'message' => 'Go to otp verify page',
            'data' => [
                'user_id' => $user->id
            ]
        ]);

    }
    public function verify(AuthRequest $authRequest): JsonResponse
    {

        $user = User::where('phone_number',$authRequest->authAllowedInputs()['phoneNumber'])->first();

        $otp = Otp::where('user_id', $user->id)
            ->where('used', 0)
            ->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())
            ->first();

        if($otp->otp_code == $authRequest->authAllowedInputs()['code'])
        {
            $otp->update(['used' => 1]);
            $token = $user->createToken($authRequest->userAgent())->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Otp code is verifyed',
                'data' => [
                    'token' => $token,
                    'userId' => $user->id
                ]
            ]);

        } else {
            return response()->json([
                'status' => 405,
                'message' => 'Otp code is not match',
            ]);
        }






    }

}

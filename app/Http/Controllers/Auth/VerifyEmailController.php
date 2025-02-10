<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Services\VerifyEmailService;
use App\Mail\EmailMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    public function verify(VerifyEmailRequest $request, VerifyEmailService $service) {
        return $service->verifyEmail($request);
    }
    public function resend_verification_link(){
        $user = User::findOrFail(auth()->user()->id);
        if(!auth()->check()){
            return response()->json(['message' => 'You have to be authorization'], 401);
        }
        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        $otp_code = rand(111111,999999);
        $otp_expire_at = now()->addMinutes(60);

        auth()->user()->update([
            'email_verification_code' => $otp_code,
            'email_verification_code_expire_at' => $otp_expire_at,
        ]);

        $data = [
            'otp_code' => $otp_code,
            'otp_expire_at' => $otp_expire_at,
        ];

        Mail::to(auth()->user()->email)
        ->send(new EmailMail($data));

        return response()->json(['message' => 'Verification link sent!'], 200);
    }
}

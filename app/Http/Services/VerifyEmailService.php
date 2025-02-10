<?php

namespace App\Http\Services;

use App\Http\Requests\VerifyEmailRequest;
use App\Mail\EmailMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class VerifyEmailService{
    public function sendEmailVerification($id){
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        $otp_code = rand(111111,999999);
        $otp_expire_at = now()->addMinutes(60);

        $user->update([
            'email_verification_code' => $otp_code,
            'email_verification_code_expire_at' => $otp_expire_at,
        ]);

        $data = [
            'otp_code' => $otp_code,
            'otp_expire_at' => $otp_expire_at,
        ];

        Mail::to($user->email)
        ->queue(new EmailMail($data));

        // return response()->json(['message' => 'Verification link sent!'], 200);
    }

    public function verifyEmail(VerifyEmailRequest $request){
        if(!auth()->check()){
            return response()->json(['message' => 'You have to be authorization'], 401);
        }
        $user = User::findOrFail(auth()->user()->id);
        if(auth()->user()->email_verification_code != (int)$request->email_verification_code){
            return response()->json(["message" => "Verification code isn't correct."], 400);
        }
        if(Carbon::now()->diffInMinutes(auth()->user()->email_verification_code_expire_at) > 60){
            return response()->json(['message' => 'Your verification code has expired.'])->setStatusCode(400);
        }
        if($user->hasVerifiedEmail()){
            return response()->json(['message' => 'Your email is already verified.'], 400);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email verified successfully.'], 200);
    }

    public function reSendEmail(){
        // $user = User::findOrFail(auth()->user()->id);
        if(!auth()->check()){
            return response()->json(['message' => 'You have to be authorization'], 401);
        }
        // if ($user->hasVerifiedEmail()) {
        //     return response()->json(["message" => "Email already verified."], 400);
        // }

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

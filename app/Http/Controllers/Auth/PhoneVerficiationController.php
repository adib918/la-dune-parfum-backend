<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class PhoneVerficiationController extends Controller
{
    public function send_verification_code(Request $request){
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sender_number = getenv("TWILIO_PHONE");

        $otp_code = rand(000000,999999);
        $otp_expire_at = now()->addMinutes(15);

        auth()->user()->update([
            'mobile_number' => $request->mobile_number,
            'otp_code' => $otp_code,
            'otp_expire_at' => $otp_expire_at,
        ]);

        $twilio = new Client($sid, $token);

        $message = $twilio->messages->create(
            $request->mobile_number, // To
            [
                "body" =>
                    "Your la-dune-parfum account verification code is " . $otp_code . ".This code will expire in 15 minutes.",
                "from" => $sender_number,
            ]
        );

        return response()->json(['message' => 'You OTP code send successfully.'])->setStatusCode(200);
    }

    public function verify_otp_code(Request $request){
        if(auth()->user()->mobile_verified_at){
            return response()->json(['message' => "Your mobile number has already verified."])->setStatusCode(400);
        }else if(Carbon::now()->diffInMinutes(auth()->user()->otp_expire_at) > 15){
            return response()->json(['message' => 'Your otp code has expired.'])->setStatusCode(400);
        }else if(auth()->user()->otp_code == (int)$request->otp_code){
            auth()->user()->update(['mobile_verified_at' => now()]);
            return response()->json(['message' => 'Your mobile number has verified successfully.'])->setStatusCode(200);
        }else{
            return response()->json(['message' => "Your otp code isn't match."])->setStatusCode(400);
        }
    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify($id, $hash) {
        $user = User::findOrFail($id);
        if(!$user){
            return response()->json(['message' => "Sorry, there is no user."], 403);
        }
        if(!hash_equals($hash, sha1($user->getEmailForVerification()))){
            return response()->json(['message' => 'Invalid/Expired url provided.'], 401);
        }

        if($user->hasVerifiedEmail()){
            return response()->json(['message' => 'Your email has been verified.'], 400);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email verified successfully.'], 200);
        // return redirect()->to('/');
    }
    public function resend_verification_link(){
        if(!auth()->check()){
            return response()->json(['message' => 'You have to be authorization'], 400);
        }
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent!'], 200);
    }
}

<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Services\VerifyEmailService;

class VerifyEmailController extends Controller
{
    public function verify(VerifyEmailRequest $request, VerifyEmailService $service) {
        return $service->verifyEmail($request);
    }
    public function resend_verification_link(VerifyEmailService $service){
        return response()->json(['message' => "test succesffull."], 200);
        return $service->reSendEmail();
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Services\VerifyEmailService;

class VerifyEmailController extends Controller
{
    public function verify(VerifyEmailRequest $request, VerifyEmailService $service) {
        return $service->verifyEmail($request);
    }
    public function resend_verification_link(VerifyEmailService $service){
        return $service->reSendEmail();
    }
}

<?php

namespace App\Http\Services;

use App\Http\Requests\ContactUsRequest;
use App\Mail\MessageMail;
use Illuminate\Support\Facades\Mail;

class SendEmailService{
    public function send(ContactUsRequest $request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => "+" . $request->phone_number,
            'message' => $request->message,
        ];

        Mail::to('example@gmail.com')
        ->queue(new MessageMail($data));

        return response()->json(['message' => 'Your message has been sent successfully.'], 200);
    }
}

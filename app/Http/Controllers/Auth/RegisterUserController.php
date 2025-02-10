<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Services\VerifyEmailService;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
    public function store(StoreUserRequest $request, VerifyEmailService $service){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $service->sendEmailVerification($user->id);
        Auth::login($user);

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $user->createToken($user->name)->plainTextToken,
            'message' => 'User logged in!',
        ]);
    }

    public function edit_email(Request $request){
        $request->validate(['email' => ['required', 'email', 'unique:users,email,' . auth()->user()->id]]);

        if(!auth()->user()->email_verified_at){
            auth()->user()->update([
                'email' => $request->email,
            ]);

            return response()->json(['message' => 'Your email has updated successfully.'])->setStatusCode(200);
        }else{
            return response()->json(['message' => 'Your email is already verified.'])->setStatusCode(400);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\updatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgot_passowrd(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['message' => __($status)], 200)
                    : response()->json(['message' => __($status)], 400);
    }

    public function reset_password(ResetPasswordRequest $request){
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? response()->json([
                        'message' => 'Password successfully rest',
                        'status' => __($status),
                    ], 200)
                    : response()->json([
                        'message' => 'Password failed to reset',
                        'email' => [__($status)],
                    ], 400);
    }

    public function update_password(updatePasswordRequest $request){
        auth()->user()->update([
            'password' => $request->password,
        ]);

        return response()->json(['message' => 'Your password has updated successfully.'])->setStatusCode(200);
    }
}

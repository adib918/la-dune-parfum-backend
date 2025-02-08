<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticatedUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    public function store(AuthenticatedUserRequest $request){
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])){

            $user = auth()->user();

            return response()->json([
                'success' => true,
                'user' => new UserResource($user),
                'token' => $user->createToken($user->name)->plainTextToken,
                'message' => 'User logged in!',
            ])->setStatusCode(200);
        }
        return response()->json([
            'success' => false,
            'message' => 'The email or password are incorrect.',
        ])->setStatusCode(404);
    }

    public function update(UpdateUserRequest $request){
        $email = $request->email;
        $name = $request->name;
        $verified_email = true;

        if($request->email == auth()->user()->email){
            $email = null;
        }
        if($request->name == auth()->user()->name){
            $name = null;
        }
        if($request->email == auth()->user()->email && $request->name == auth()->user()->name){
            return response()->json(['message' => "You can't update your account!"])->setStatusCode(404);
        }
        auth()->user()->update([
            'name' => $name ? $name : auth()->user()->name,
            'email' => $email ? $email : auth()->user()->email,
        ]);
        if($email != null){
            auth()->user()->update([
                'email_verified_at' => null,
            ]);
            $verified_email = false;
        }

        return response()->json(['message' => 'Your account has updated successfully.', 'verified_email' => $verified_email])->setStatusCode(200);
    }

    public function show(){
        if(!Auth::check()){
            return response()->json([
                'message' => 'You have to be signed in',
            ], 400);
        }
        return (new UserResource(auth()->user()))
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Request $request){
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();
        Session::flush();

        return response()->json(null, 204);
    }
}

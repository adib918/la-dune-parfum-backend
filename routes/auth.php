<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\UserAddressController;
use App\Http\Controllers\auth\VerifyEmailController;
use App\Http\Controllers\Auth\PhoneVerficiationController;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Services\SendEmailService;
use App\Http\Services\VerifyEmailService;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterUserController::class, 'store'])->middleware('guest')->name('user.register');
Route::post('/edit-email', [RegisterUserController::class, 'edit_email'])->middleware('auth:sanctum')->name('email.edit');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('user.login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('user.logout');

// Route::post('/verified-email', [VerifyEmailController::class, 'verify'])->middleware(['auth:sanctum'])->name('verification.verify');

// Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend_verification_link'])->middleware(['auth:sanctum'])->name('verification.send');

Route::post( '/verification-code', [VerifyEmailController::class, 'resend_verification_link'])->middleware(['auth:sanctum']);
Route::post( '/verify-email', function(VerifyEmailRequest $request, VerifyEmailService $service){
    return $service->verifyEmail($request);
})->middleware(['auth:sanctum', 'throttle:6,1']);

Route::post('/forgot-password', [PasswordResetController::class, 'forgot_passowrd'])->name('password.email');

Route::get('/reset-password/{token}/{email}', function (string $token, string $email) {
    return response()->json(['token' => $token, 'email' => $email], 200);
})->domain("https://www.laduneparfum.com")->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'reset_password'])->name('password.update');

Route::post('/send-phone-verification-code', [PhoneVerficiationController::class, 'send_verification_code'])->middleware('auth:sanctum')->name('send.verification_code');
Route::post('/verify-phone-verification-code', [PhoneVerficiationController::class, 'verify_otp_code'])->middleware('auth:sanctum')->name('verify.verification_code');

Route::post('/address-store', [UserAddressController::class, 'store'])->middleware('auth:sanctum')->name('address.store');

Route::patch('/update-user', [AuthenticatedSessionController::class, 'update'])->middleware('auth:sanctum')->name('user.update');
Route::patch('/update-address/{addressIndex}', [UserAddressController::class, 'update'])->middleware('auth:sanctum')->name('address.update');
Route::delete('/delete-address/{addressIndex}', [UserAddressController::class, 'destroy'])->middleware('auth:sanctum')->name('address.delete');
Route::post('/update-password', [PasswordResetController::class, 'update_password'])->middleware('auth:sanctum');

Route::post('/send-message', [SendEmailService::class, 'send']);

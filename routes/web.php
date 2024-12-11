<?php


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Auth\PaymentController2;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Homepage route
Route::get('/', function () {
    return Inertia::render('Homepage');
     
});
// Register route
Route::get('/register', function () {
    return Inertia::render('Regpage', [
        'pageTitle' => 'Registration' // Pass the title here
    ]);
});

Route::post('/register', [CustomerController::class, 'store'])->name('register');



//Login route
Route::get('/login', function () {
    return Inertia::render('Loginpage');
});


// Combined validation for email/username and password
Route::post('/validate-credentials', [LoginController::class, 'validateCredentials']);

//Forgot Password route
Route::get('/forgotpassword', function () {
    return Inertia::render('Forgot-Passwordpage');
});

Route::post('/forgotpassword', [PasswordResetController::class, 'sendResetCode'])->name('forgot.password');

//Enter-Verfication Code route
Route::get('/verification',function(){
    return Inertia::render('Verificationpage');
});

Route::post('/verification', [PasswordResetController::class, 'verifyResetCode'])->name('verify.reset.code');

//Set-New Password route
Route::get('/resetpassword',function(){
    return Inertia::render('ResetPasswordpage');
});

Route::post('/resetpassword', [PasswordResetController::class, 'resetPassword']);

// Shoppingpage route
Route::get('/shopping', function () {
    return Inertia::render('Shoppingpage', [
        'categories' => [
            ['id' => 1, 'name' => 'Electronics'],
            ['id' => 2, 'name' => 'Fashion'],
            ['id' => 3, 'name' => 'Home & Kitchen'],
            // Add more categories as needed
        ],
    ]);
})->name('shopping');


//Payment route
Route::get('/payment', function(){
    return Inertia::render('Paymentpage');
});

Route::post('/api/payment', [PaymentController2::class, 'processPayment']);









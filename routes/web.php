<?php


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;
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
    return Inertia::render('Loginpage', [
        'pageTitle' => 'Log-in' // Pass the title here
    ]);
});


// Combined validation for email/username and password
Route::post('/validate-credentials', [LoginController::class, 'validateCredentials']);

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








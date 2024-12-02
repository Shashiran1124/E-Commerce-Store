<?php
namespace App\Http\Controllers;

use App\Mail\registrationSuccessful;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function store(Request $request)
{
    // Validate input
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:customers',
        'email' => 'required|string|email|max:255|unique:customers',
        'password' => 'required|string|min:8|confirmed',
    ]);

    

    // Create customer
    $customer = Customer::create([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'username' => $validatedData['username'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);
    {

}


    // Send registration success email
    Mail::to($customer->email)->send(new registrationSuccessful($customer));

   
}


}

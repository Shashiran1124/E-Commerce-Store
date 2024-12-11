<?php
namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // Combined validation for email/username and password
    public function validateCredentials(Request $request)
    {
        // Validate request input
        $request->validate([
            'emailOrUsername' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if the email or username exists in the database
        $customer = Customer::where('email', $request->emailOrUsername)
                            ->orWhere('username', $request->emailOrUsername)
                            ->first();

        // If customer doesn't exist or password doesn't match, return error
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email/username or password.'
            ], 401);
        }

        // If everything is valid, log the user in
        Auth::login($customer);

        // Return success message
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'customer' => $customer // Optional: return customer details if needed
        ]);
    }
}

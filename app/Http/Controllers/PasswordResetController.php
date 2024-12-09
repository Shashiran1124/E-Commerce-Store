<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class PasswordResetController extends Controller
{
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|exists:customers',
        ]);

        $code = rand(100000, 999999); // Generate a 6-digit verification code

        // Store the code in the database or session
        session(['reset_code' => $code]);
        session(['email' => $request->email]);
        session(['reset_code_created_at' => now()]); // Set the reset code creation time

        // Send the email
        Mail::to($request->email)->send(new ResetPasswordMail($code));

        return response()->json(['message' => 'A verification code has been sent to your email.'], 200);
    }

    // Verify Reset Code
    public function verifyResetCode(Request $request)
    {
        // Validate code
        $request->validate([
            'code' => 'required|string',
        ]);

        // Check if the code exists in the session and is not expired
        if ($request->code == session('reset_code')) {
            // Check if the reset code is expired (e.g., 15 minutes expiration)
            if (now()->diffInMinutes(session('reset_code_created_at')) > 15) {
                // Code expired
                return response()->json([
                    'message' => 'The reset code has expired.'
                ], 400);
            }

            // Code is valid, proceed to allow the user to reset their password
            return response()->json([
                'message' => 'Code verified. Please set your new password.'
            ]);
        }

        // Invalid code
        return response()->json([
            'message' => 'Invalid reset code.'
        ], 400);
    }
    
    public function resetPassword(Request $request)
{
    // Validate the password fields
    $request->validate([
        'password' => 'required|string|min:8',
        'password_confirmation' => 'required|string|min:8', // Ensure the confirmation is also validated
    ]);

    // Check if password matches confirmation manually
    if ($request->password !== $request->password_confirmation) {
        return response()->json(['message' => 'Passwords do not match.'], 400);
    }

    // Retrieve customer based on the session email or provided identifier
    $customer = Customer::where('email', session('email'))->first(); // Or use 'id' or other identifier

    if (!$customer) {
        return response()->json(['message' => 'User not found or invalid request.'], 404);
    }

    // Update the password
    $customer->password = Hash::make($request->password); // Hash the new password
    $customer->save(); // Save the updated customer record

    // Clear session data
    session()->forget(['reset_code', 'email', 'reset_code_created_at']);

    return response()->json(['message' => 'Your password has been successfully reset.']);
}





}

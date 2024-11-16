<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class RegisterController extends Controller
{
    /**
     * Show the registration page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration process.
     *
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            // The validated data from the request is automatically available
            $data = $request->validated();

            // Check if the email already exists
            if (User::where('email', $data['email'])->exists()) {
                return redirect()->back()->with('error', 'Email is already taken.');
            }

            // Create the user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Log the user in after registration
            Auth::loginUsingId($user->id);

            // Redirect to the home page with a success message
            return redirect('/')->with('success', 'User registered successfully!');

        } catch (Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Registration failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred during registration. Please try again later.');
        }
    }
}

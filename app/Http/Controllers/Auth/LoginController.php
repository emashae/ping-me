<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Exception;

class LoginController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view("auth.login");
    }

    /**
     * Handle the login attempt.
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            // Attempt to log the user in
            if (Auth::attempt($credentials)) {
                // Regenerate the session to prevent session fixation attacks
                $request->session()->regenerate();

                return redirect()->intended('/')
                    ->with('success', 'Signed in successfully!');
            }

            // If login attempt fails, redirect back with error message
            return redirect()->route('login')
                ->with('error', 'The provided credentials are incorrect.')
                ->withInput($request->only('email'));

        } catch (Exception $e) {
            // Log the exception for debugging
            Log::error('Login failed: ' . $e->getMessage());

            return redirect()->route('login')
                ->with('error', 'An error occurred. Please try again later.');
        }
    }

    /**
     * Handle user logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        try {
            // Invalidate session and regenerate token for security purposes
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();

            return redirect()->route('login')->with('success', 'Logged out successfully.');
        } catch (Exception $e) {
            // Log any errors that occur during logout
            Log::error('Logout failed: ' . $e->getMessage());

            return redirect()->route('login')->with('error', 'An error occurred while logging out.');
        }
    }
}

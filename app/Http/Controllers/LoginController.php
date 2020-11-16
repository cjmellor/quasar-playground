<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Authenticate a user
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string
     */
    public function authenticateUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true)) {
            Transactions::create([
                'severity' => 'info',
                'message' => \auth()->user()->name." has logged in"
            ]);

            return response()->json(['message' => 'Success']);
        }

        Transactions::create([
            'severity' => 'warm',
            'message' => "$request->email has unsuccessfully tried to login"
        ]);

        return response()->json(['message' => 'An error has occurred'], 404);
    }

    /**
     * Log a user out
     */
    public function logout()
    {
        Transactions::create([
            'severity' => 'info',
            'message' => \auth()->user()->name." has logged out"
        ]);

        Auth::logout();
    }
}

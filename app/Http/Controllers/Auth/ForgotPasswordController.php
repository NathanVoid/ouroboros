<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = Password::sendResetLink($request->only('email'));

        return $response === Password::RESET_LINK_SENT
            ? back()->with('status', 'We have emailed your password reset link!')
            : back()->withErrors(['email' => 'Unable to send reset link.']);
    }
}

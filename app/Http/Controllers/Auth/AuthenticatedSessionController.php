<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Add toast message to session with the admin's name
    $adminName = $request->user()->name;
    toastr()->success("Welcome Back, {$adminName}!!!");

    if ($request->user()->usertype === 'admin') {
        return redirect('admin/dashboard');
    } elseif ($request->user()->usertype === 'user') {
        return redirect()->route('dashboard'); // Redirect to user dashboard
    }

        return redirect()->intended(route('home.form', ));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

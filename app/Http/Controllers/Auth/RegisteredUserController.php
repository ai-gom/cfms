<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Services;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $services = Services::all(); // Fetch all services from the database
        return view('admin.Account', compact('services')); // Pass $services to the view
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'usertype' => 'required|string|in:admin,user',
            'service_id' => ['required', 'exists:services,id'], // Validate service_id
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
        ]);

        // Assign the user to the selected service
        $service = Services::find($request->service_id);
        $service->user_id = $user->id;
        $service->save();

        // Flash a success message
        toastr()->success('Account created and service assigned successfully.');

        // Fetch all services for the account page
        $services = Services::all();

        // Redirect to the account page with services
        return redirect()->route('Account')->with('services', $services);
    }
}

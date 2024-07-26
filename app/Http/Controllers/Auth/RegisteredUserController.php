<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\GymUser;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse{
        $messages = [
            'email.ends_with' => 'The email must be an APU email.',
            'confirm_password.same' => 'The confirm password and password must match.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number and one special character.'
        ];
    // Validate the incoming request
    $validatedData = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255','unique:users,username'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email','ends_with:mail.apu.edu.my'],
        'password' => ['required', 'min:8','regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/'],
        'confirm_password' => ['required', 'same:password'],
    ], $messages);

    // Create a new user
    $user = User::create([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'username' => $validatedData['username'], 
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // If user creation is successful
    if ($user) {
            $gymUser = GymUser::create([
                'user_id' => $user->id,
            ]);
            // Trigger the Registered event
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            // Redirect to the verification notice route
            return redirect()->route('verification.notice');
        
    }

    // If user creation or saving fails, return with error
    return redirect()->route('register')->with('error', 'Failed to register');
}
}

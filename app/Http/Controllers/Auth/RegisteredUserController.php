<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
        public function store(Request $request): Response
        {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:users,name'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            try {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => 'Could not create user.',
                    'error' => $e->getMessage()
                ], 500);
            }

            // Si pour une raison quelconque l'utilisateur n'a pas été créé
            if (! $user) {
                return response()->json([
                    'message' => 'User creation failed.'
                ], 500);
            }

            event(new Registered($user));

            Auth::login($user);

            return response()->json([
                'user' => $user
            ], 201);
        }

}

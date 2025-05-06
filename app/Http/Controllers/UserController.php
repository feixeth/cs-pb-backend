<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function me()
    {
        $user = Auth::user()->load(['strategies.votes']);

        return response()->json([
            'user' => $user,
            'strategies' => $user->strategies()->withCount([
                'votes as score' => fn($q) => $q->select(\DB::raw('COALESCE(SUM(value), 0)'))
            ])->latest()->get(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete(str_replace('/storage/', 'public/', $user->avatar));
            }

            $path = $request->file('avatar')->store('public/avatars');
            $validated['avatar'] = Storage::url($path);
        }

        $user->update($validated);

        return response()->json($user);
    }
}

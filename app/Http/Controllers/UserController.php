<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Update the user's role.
     */
    public function updateRole(Request $request, User $user)
    {
        // Don't allow user to change their own role if they are the only admin
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot change your own role.']);
        }

        $request->validate([
            'role' => 'required|in:admin,manager,staff'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', "Role for {$user->name} updated successfully.");
    }
}

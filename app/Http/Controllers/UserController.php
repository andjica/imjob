<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function userEmailUpdate(Request $request, $id)
{
    $request->validate([
        'email' => 'required|email|unique:users,email',
    ]);

    $user = User::findOrFail($id);
    $user->email = $request->email;
    $user->save();

    return redirect()->back()->with('success', 'Email updated successfully!');
}

public function userPasswordUpdate(Request $request, $id)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = User::findOrFail($id);

    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->back()->with('success', 'Password updated successfully!');
}
}

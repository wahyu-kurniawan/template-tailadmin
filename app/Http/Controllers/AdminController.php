<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function verifyUsersList()
    {
        $pendingUsers = User::where('status', 'pending_verification')->get();
        return view('admin.verify-users', compact('pendingUsers'));
    }

    public function activateUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return back()->with('success', "Akun user {$user->name} telah diaktifkan.");
    }
}

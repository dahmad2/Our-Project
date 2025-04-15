<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
{
    $totalUsers = User::count();
    $approvedUsers = User::where('is_approved', true)->count();
    $pendingUsers = User::where('is_approved', false)->get();
    $totalAssets = \App\Models\Asset::count();

    return view('admin.dashboard', compact('totalUsers', 'approvedUsers', 'pendingUsers', 'totalAssets'));
}

    // List all users (including pending ones)
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // List only pending users (not approved yet)
    public function pending()
    {
        $users = User::where('role', 'user')
                    ->where('is_approved', false)
                    ->get();

        return view('admin.users', compact('users'));
    }

    // Approve a user
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return back()->with('success', 'User approved successfully.');
    }

    // Reject (delete) a user
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User rejected and deleted.');
    }
    public function updateRole(Request $request, $id)
{
    $request->validate([
        'role' => 'required|in:admin,user',
    ]);

    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->save();

    return redirect()->back()->with('success', 'User role updated successfully.');
}

}

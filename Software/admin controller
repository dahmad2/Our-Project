<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovedUser;
use App\Mail\RejectedUser;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        Mail::to($user->email)->send(new ApprovedUser());

        return redirect()->back()->with('success', 'User approved!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = false;
        $user->save();

        Mail::to($user->email)->send(new RejectedUser());

        return redirect()->back()->with('success', 'User rejected.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use App\Models\Url;

class AdminController extends Controller
{
    public function dashboard()
    {
        $clients = User::where('is_admin', false)->with('websites.urls')->get();
        return view('admin.dashboard', compact('clients'));
    }

    public function createClient()
    {
        return view('admin.clients.create');
    }

    public function storeClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new \App\Models\User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_admin = false; // Just to be safe
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Client created successfully.');
    }

}

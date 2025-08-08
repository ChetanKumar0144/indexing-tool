<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Auth::user()->websites;
        return view('websites.index', compact('websites'));
    }

    public function create()
    {
        return view('websites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|url',
            'service_account_file' => 'required|file|mimes:json'
        ]);

        $path = $request->file('service_account_file')->store('service-accounts');

        Website::create([
            'user_id' => Auth::id(),
            'domain' => $request->domain,
            'service_account_file' => $path
        ]);

        return redirect()->route('websites.index')->with('success', 'Website added');
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $websiteIds = $user->websites->pluck('id');

        $totalWebsites = $user->websites()->count();
        $totalUrls = Url::whereIn('website_id', $websiteIds)->count();
        $totalIndexed = Url::whereIn('website_id', $websiteIds)->where('status', 'success')->count();
        $totalFailed = Url::whereIn('website_id', $websiteIds)->where('status', 'failed')->count();

        $recentUrls = Url::whereIn('website_id', $websiteIds)->latest()->take(5)->get();

        $urlsByDate = Url::whereIn('website_id', $websiteIds)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard', compact(
            'totalWebsites', 'totalUrls',
            'totalIndexed', 'totalFailed',
            'recentUrls', 'urlsByDate'
        ));
    }
}

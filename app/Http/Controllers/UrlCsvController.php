<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\GoogleSearchConsole\GoogleSearchConsole;
use App\Helpers\GoogleIndexing;

class UrlCsvController extends Controller
{
    public function form($websiteId)
    {
        $website = Website::where('id', $websiteId)->where('user_id', Auth::id())->firstOrFail();
        return view('urls.upload', compact('website'));
    }

    public function upload(Request $request, $websiteId)
    {
        $website = Website::where('id', $websiteId)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $lines = array_map('str_getcsv', file($file->getRealPath()));
        
        foreach ($lines as $line) {
            $path = trim($line[0]);
            if (!$path) continue;

            $url = new Url();
            $url->website_id = $website->id;
            $url->path = $path;

            try {
                $fullUrl = rtrim($website->domain, '/') . '/' . ltrim($path, '/');

                GoogleIndexing::indexUrl(
                    storage_path("app/{$website->service_account_file}"),
                    $fullUrl
                );

                $url->status = 'success';
                $url->indexed_at = now();
            } catch (\Exception $e) {
                $url->status = 'failed';
                $url->response = $e->getMessage();
            }

            $url->save();
        }

        return redirect()->route('urls.index', $website->id)->with('success', 'CSV uploaded and URLs submitted!');
    }
}

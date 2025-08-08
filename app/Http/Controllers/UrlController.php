<?php
namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleSearchConsole\GoogleSearchConsole;
use App\Helpers\GoogleIndexing;
use Illuminate\Support\Facades\Log;


class UrlController extends Controller
{
    public function index($websiteId)
    {
        $website = Website::where('id', $websiteId)->where('user_id', Auth::id())->firstOrFail();
        $urls = $website->urls;
        return view('urls.index', compact('website', 'urls'));
    }


    public function store(Request $request, $websiteId)
    {
        $request->validate([
            'paths' => 'required|string',
        ]);

        $website = Website::where('id', $websiteId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $paths = explode("\n", $request->paths); // split by line
        $paths = array_map('trim', $paths);      // trim extra spaces
        $paths = array_filter($paths);           // remove empty lines

        foreach ($paths as $path) {
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

        return redirect()->back()->with('success', 'All URLs submitted successfully.');
    }

}

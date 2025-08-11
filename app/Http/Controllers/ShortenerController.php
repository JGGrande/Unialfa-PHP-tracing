<?php
namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortenerController extends Controller
{
    public function index()
    {
        $urls = Url::latest()->limit(20)->get();
        return view('shortener.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        do {
            $code = Str::random(6);
        } while (Url::where('code', $code)->exists());

        $url = Url::create([
            'code' => $code,
            'target_url' => $request->input('url'),
        ]);

        return redirect()->route('home')->with('success', url("/{$code}"));
    }

    public function redirect($code)
    {
        $url = Url::where('code', $code)->firstOrFail();
        $url->increment('clicks');
        return redirect()->away($url->target_url);
    }
}

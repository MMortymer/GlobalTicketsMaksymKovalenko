<?php

// app/Http/Controllers/UrlController.php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'urls' => auth()->user()->urls()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'original_url' => 'required|url'
        ]);

        // Generate a 7-character random string for the shortened URL.
        // The choice of 7 characters strikes a balance between being user-friendly
        // and providing a large number of unique combinations (62^7, using upper and lower case letters and digits).
        // This significantly minimizes the risk of collisions even with a large
        // number of entries, ensuring the system remains scalable and efficient in the long term.
        // An alternative to this approach would be using Base62 encoding,
        // but for simplicity, we are using a random string. In case of a collision,
        // we will attempt to generate another one and save it again.
        do {
            $shortenedUrl = Str::random(7);
        } while (Url::where('shortened_url', $shortenedUrl)->exists());

        auth()->user()->urls()->create([
            'original_url' => $request->original_url,
            'shortened_url' => $shortenedUrl,
        ]);

        return redirect()->back();
    }


    /**
     * Redirect to the original URL.
     *
     * @param  string  $shortened_url
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function redirect(string $shortened_url)
    {
        $url = Url::where('shortened_url', $shortened_url)->firstOrFail();

        return redirect()->away($url->original_url);
    }
}
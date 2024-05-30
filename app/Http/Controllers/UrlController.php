<?php

// app/Http/Controllers/UrlController.php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
        $urls = auth()->user()->urls()->paginate(10); // 10 items per page
        
        return Inertia::render('Dashboard', [
            'urls' => $urls,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
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
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  \App\Models\Url  $url
     * @return RedirectResponse
     */
    public function update(Request $request, Url $url): RedirectResponse
    {
        if ($request->user()->cannot('update', $url)) {
            abort(403);
        }

        $request->validate([
            'original_url' => 'required|url'
        ]);

        $url->update($request->only('original_url'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  \App\Models\Url  $url
     * @return RedirectResponse
     */
    public function destroy(Request $request, Url $url): RedirectResponse
    {
        if ($request->user()->cannot('delete', $url)) {
            abort(403);
        }

        $url->delete();

        return redirect()->back();
    }


    /**
     * Redirect to the original URL.
     *
     * @param  string  $shortened_url
     * @return RedirectResponse
     */
    public function redirect(string $shortened_url): RedirectResponse
    {
        $url = Url::where('shortened_url', $shortened_url)->firstOrFail();

        return redirect()->away($url->original_url);
    }
}
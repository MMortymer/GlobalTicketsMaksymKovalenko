<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UrlResource;
use App\Http\Resources\V1\UrlCollection;
use App\Http\Requests\V1\StoreUrlRequest;
use App\Http\Requests\V1\UpdateUrlRequest;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     * Example request - GET: http://127.0.0.1:8000/api/v1/urls
     */
    public function index()
    {
        return new UrlCollection(Url::paginate());
    }

    /**
     * Display the specified resource.
     * Example request - GET: http://127.0.0.1:8000/api/v1/urls/1
     */
    public function show(Request $request, Url $url)
    {
        return new UrlResource($url);
    }


    /**
     * Store a newly created resource in storage.
     * Example request - POST: http://127.0.0.1:8000/api/v1/urls
     * Example request json body -
     * ---
     * {
     *     "original_url": "https://www.global-tickets.com/en/",
     *     "user_id": 1
     * }
     * ---
     * In a real production application, the user_id would typically not be provided directly in the request body.
     * Instead, the authenticated user would be determined from the token in the request header.
     * For simplicity and testing purposes in this example, the user_id is provided.
     * However, in a secure production environment, user association should be handled via authentication tokens and proper authorization mechanisms.
    */
    public function store(StoreUrlRequest $request)
    {
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

        $url = Url::create([
            'user_id' => $request->user_id,
            'original_url' => $request->original_url,
            'shortened_url' => $shortenedUrl,
        ]);

        return new UrlResource($url);
    }

    /**
     * Update the specified resource in storage.
     * Example request - PUT: http://127.0.0.1:8000/api/v1/urls/1
     */
    public function update(UpdateUrlRequest $request, Url $url)
    {
        $url->update($request->all());
        return new UrlResource($url);
    }

    /**
     * Remove the specified resource from storage.
     * Example request - DELETE: http://127.0.0.1:8000/api/v1/urls/1
     */
    public function destroy( Url $url)
    {
        $url->delete();
    }
}

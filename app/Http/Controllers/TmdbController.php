<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TmdbController extends Controller
{
    public function getVideo()
    {
        $apiKey = '7b8da597ddda3922e0a74cec92c25b67';
        $response = Http::get("https://api.themoviedb.org/3/movie/550/videos?api_key={$apiKey}");
        return response()->json($response->json());
    }
}

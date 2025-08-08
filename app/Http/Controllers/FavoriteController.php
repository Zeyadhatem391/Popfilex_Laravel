<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoriteRequest;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->favorites;
    }

    public function store(StoreFavoriteRequest $request)
    {
        $data = $request->validated();

        $favorite = Favorite::firstOrCreate([
            'user_id' => $request->user()->id,
            'movie_id' => $data['movie_id'],
        ], $data);

        return response()->json($favorite, 201);
    }

    public function destroy(Request $request, $movie_id)
    {
        $request->user()->favorites()->where('movie_id', $movie_id)->delete();
        return response()->json(['message' => 'Favorite removed']);
    }
}

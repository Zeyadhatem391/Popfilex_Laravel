<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        if (!$profile) {
            return response()->json(['message' => 'No profile found'], 200); // رجع 200 بدل 404
        }

        return response()->json($profile);
    }


    public function store(StoreProfileRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('photo', 'public'); //string
            $validatedData['image'] = $path;
        }
        if (Profile::where('user_id', $user_id)->exists()) {
            return response()->json(['message' => 'Profile already exists'], 400);
        }
        $profile = Profile::create($validatedData);
        return response()->json($profile, 201);
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $profile = Profile::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete($profile->image);
            }

            $path = $request->file('image')->store('photo', 'public');
            $data['image'] = $path;
        }

        $profile->update($data);

        return response()->json($profile, 200);
    }


    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $profile = Profile::findOrFail($id);
        if ($profile->user_id != $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $profile->delete();
        return response()->json(null, 204);
    }

}

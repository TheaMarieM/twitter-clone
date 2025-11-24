<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show a user's profile
    public function show(User $user)
    {
        // Get user's tweets with likes count, ordered by latest
        $tweets = $user->tweets()
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get total likes received by the user
        $totalLikesReceived = $user->totalLikesReceived();

        // Get total number of tweets
        $totalTweets = $user->tweets()->count();

        return view('profile.show', compact('user', 'tweets', 'totalLikesReceived', 'totalTweets'));
    }

    // Show the profile edit form
    public function edit(User $user)
    {
        if (! Auth::check() || Auth::id() !== $user->id) {
            abort(403);
        }

        return view('profile.edit', compact('user'));
    }

    // Handle profile update
    public function update(Request $request, User $user)
    {
        if (! Auth::check() || Auth::id() !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');

            // Delete old image if present
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $validated['profile_image'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user)->with('success', 'Profile updated successfully!');
    }
}

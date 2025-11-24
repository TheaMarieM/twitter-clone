<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like/unlike a tweet
     */
    public function toggle(Tweet $tweet)
    {
        $user = Auth::user();

        // Check if the user already liked the tweet
        $like = $tweet->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Unlike the tweet
            $like->delete();
            $liked = false;
        } else {
            // Like the tweet
            $tweet->likes()->create([
                'user_id' => $user->id,
            ]);
            $liked = true;
        }

        // If AJAX request, return JSON response
        if (request()->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $tweet->likes()->count(),
            ]);
        }

        // Otherwise, redirect back
        return redirect()->back();
    }
}

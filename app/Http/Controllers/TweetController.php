<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TweetController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $tweets = Tweet::with(['user', 'likes'])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('tweets.index', compact('tweets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        /** @var \App\Models\User $user */
        $user->tweets()->create($validated);

        return redirect()->route('home')->with('success', 'Tweet posted successfully!');
    }

    public function edit(Tweet $tweet)
    {
        // Log auth state for troubleshooting edit access
        logger()->info('TweetController@edit called', [
            'auth_check' => Auth::check(),
            'auth_id' => Auth::id(),
            'tweet_id' => $tweet->id,
            'tweet_user_id' => $tweet->user_id,
        ]);

        $this->authorize('update', $tweet);

        return view('tweets.edit', compact('tweet'));
    }

    public function update(Request $request, Tweet $tweet)
    {
        $this->authorize('update', $tweet);

        $validated = $request->validate([
            'content' => 'required|string|max:280',
        ]);

        $tweet->update([
            'content' => $validated['content'],
            'is_edited' => true,
        ]);

        return redirect()->route('home')->with('success', 'Tweet updated successfully!');
    }

    public function destroy(Tweet $tweet)
    {
        $this->authorize('delete', $tweet);

        $tweet->delete();

        return redirect()->back()->with('success', 'Tweet deleted successfully!');
    }
}

@extends('layouts.app')

@section('title', 'Home - Tweet Tweet')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-6 mt-6">
    <!-- Main column (spans 2 on md+) -->
    <div>
    <!-- Tweet Form -->
    @auth
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex space-x-3">
            <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-12 h-12 rounded-full">
            <div class="flex-1">
                <form action="{{ route('tweets.store') }}" method="POST">
                    @csrf
                    <textarea name="content" rows="3" placeholder="What's happening?" 
                        class="w-full border-0 focus:ring-0 resize-none text-lg text-gray-700 placeholder-gray-400" 
                        maxlength="280" 
                        oninput="updateCharCount(this)"
                        required></textarea>
                    
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div class="flex justify-between items-center mt-3 pt-3 border-t">
                        <span id="char-count" class="text-sm text-gray-500">0/280</span>
                        <button type="submit" id="tweet-submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full font-bold transition">
                            Tweet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <!-- Tweets List -->
    <div class="space-y-6">
        @forelse($tweets as $tweet)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex space-x-3">
                    <a href="{{ route('profile.show', $tweet->user) }}">
                        <img src="{{ $tweet->user->profile_image_url }}" alt="{{ $tweet->user->name }}" class="w-12 h-12 rounded-full">
                    </a>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-1">
                            <a href="{{ route('profile.show', $tweet->user) }}" class="font-bold hover:underline">
                                {{ $tweet->user->name }}
                            </a>
                            <span class="text-gray-500 text-sm">
                                {{ $tweet->created_at->diffForHumans() }}
                            </span>
                            @if($tweet->is_edited)
                                <span class="text-gray-500 text-sm italic">(edited)</span>
                            @endif
                        </div>
                        
                        <p class="text-gray-800 mb-3 whitespace-pre-wrap break-words">{{ $tweet->content }}</p>
                        
                        <div class="flex items-center mt-2">
                            <div class="inline-flex items-center gap-x-4">
                                @auth
                                    <button data-tweet-id="{{ $tweet->id }}" onclick="toggleLike(this)" class="inline-flex items-center gap-2 text-gray-500 hover:text-red-500 transition mr-4">
                                        <i class="{{ $tweet->isLikedBy(auth()->user()) ? 'fas fa-heart text-red-500' : 'far fa-heart' }}"></i>
                                        <span class="likes-count">{{ $tweet->likes_count }}</span>
                                    </button>
                                @else
                                    <div class="inline-flex items-center gap-2 text-gray-500 mr-4">
                                        <i class="far fa-heart"></i>
                                        <span>{{ $tweet->likes_count }}</span>
                                    </div>
                                @endauth

                                @can('update', $tweet)
                                    <a href="{{ route('tweets.edit', $tweet) }}" class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-600 transition mr-4">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                @endcan

                                @can('delete', $tweet)
                                    <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 text-red-500 hover:text-red-600 transition">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-dove text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">No tweets yet. Be the first to tweet!</p>
            </div>
        @endforelse

        <div class="mt-4 flex justify-center">{{ $tweets->links() }}</div>
    </div>
    
</div>
</div>
@endsection
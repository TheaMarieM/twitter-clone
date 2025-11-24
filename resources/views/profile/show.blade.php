@extends('layouts.app')

@section('title', $user->name . ' - Profile')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <!-- Cover Image -->
        <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600"></div>
        
        <!-- Profile Info -->
        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-5 -mt-16 sm:-mt-12">
                <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" 
                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                
                <div class="mt-4 sm:mt-0 flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        </div>
                        @if(auth()->check() && auth()->id() === $user->id)
                            <div class="ml-4">
                                <a href="{{ route('profile.edit', $user) }}" class="inline-block bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Edit Profile</a>
                            </div>
                        @endif
                    </div>

                    @if($user->bio)
                        <p class="text-gray-700 mt-3 whitespace-pre-wrap">{{ $user->bio }}</p>
                    @else
                        <p class="text-gray-500 mt-3">No bio yet. Add one to tell people about yourself.</p>
                    @endif
                </div>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t">
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-500">{{ $totalTweets }}</p>
                    <p class="text-gray-500">Tweets</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-red-500">{{ $totalLikesReceived }}</p>
                    <p class="text-gray-500">Likes Received</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-700">{{ $user->created_at->format('M Y') }}</p>
                    <p class="text-gray-500">Joined</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User's Tweets -->
    <div class="space-y-4">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            @if(auth()->check() && auth()->id() === $user->id)
                Your Tweets
            @else
                {{ $user->name }}'s Tweets
            @endif
        </h2>

        @forelse($tweets as $tweet)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex space-x-3">
                    <img src="{{ $tweet->user->profile_image_url }}" alt="{{ $tweet->user->name }}" class="w-12 h-12 rounded-full">
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="font-bold">{{ $tweet->user->name }}</span>
                            <span class="text-gray-500 text-sm">
                                {{ $tweet->created_at->diffForHumans() }}
                            </span>
                            @if($tweet->is_edited)
                                <span class="text-gray-500 text-sm italic">(edited)</span>
                            @endif
                        </div>
                        
                        <p class="text-gray-800 mb-3 whitespace-pre-wrap break-words">{{ $tweet->content }}</p>
                        
                        <div class="flex items-center space-x-6">
                            @auth
                                <button data-tweet-id="{{ $tweet->id }}" onclick="toggleLike(this)" class="flex items-center space-x-2 text-gray-500 hover:text-red-500 transition">
                                    <i class="fa-heart {{ $tweet->isLikedBy(auth()->user()) ? 'fas text-red-500' : 'far' }}"></i>
                                    <span class="likes-count">{{ $tweet->likes_count }}</span>
                                </button>
                            @else
                                <div class="flex items-center space-x-2 text-gray-500">
                                    <i class="far fa-heart"></i>
                                    <span>{{ $tweet->likes_count }}</span>
                                </div>
                            @endauth

                            @can('update', $tweet)
                                <a href="{{ route('tweets.edit', $tweet) }}" class="text-blue-500 hover:text-blue-600 transition">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endcan

                            @can('delete', $tweet)
                                <form action="{{ route('tweets.destroy', $tweet) }}" method="POST" class="inline" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 transition">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-dove text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">
                    @if(auth()->check() && auth()->id() === $user->id)
                        You haven't posted any tweets yet.
                    @else
                        {{ $user->name }} hasn't posted any tweets yet.
                    @endif
                </p>
            </div>
        @endforelse

        {{ $tweets->links() }}
    </div>
</div>
@endsection

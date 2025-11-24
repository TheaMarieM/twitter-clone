@extends('layouts.app')

@section('title', 'Edit Tweet - Tweet Tweet')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-600 mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold">Edit Tweet</h2>
        </div>

        <div class="flex space-x-3">
            <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-12 h-12 rounded-full">
            
            <div class="flex-1">
                <form action="{{ route('tweets.update', $tweet) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <textarea name="content" rows="5" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none text-lg @error('content') border-red-500 @enderror" 
                        maxlength="280" 
                        oninput="updateCharCount(this)"
                        required>{{ old('content', $tweet->content) }}</textarea>
                    
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <div class="flex justify-between items-center mt-4">
                        <span id="char-count" class="text-sm text-gray-500">{{ strlen($tweet->content) }}/280</span>
                        <div class="space-x-3">
                            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 px-6 py-2 rounded-full border border-gray-300 font-bold transition">
                                Cancel
                            </a>
                            <button type="submit" id="tweet-submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full font-bold transition">
                                Update Tweet
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize character count on page load
    window.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="content"]');
        updateCharCount(textarea);
    });
</script>
@endsection
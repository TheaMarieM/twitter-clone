@extends('layouts.app')

@section('title', 'Edit Profile - ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('profile.show', $user) }}" class="text-blue-500 hover:text-blue-600 mr-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="text-2xl font-bold">Edit Profile</h2>
        </div>

        <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="bio" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Profile Image</label>
                    <div class="flex items-center space-x-4 mt-2">
                        <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full">
                        <input type="file" name="profile_image" accept="image/*" />
                    </div>
                    @error('profile_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end space-x-3 mt-4">
                    <a href="{{ route('profile.show', $user) }}" class="px-4 py-2 border rounded-md text-gray-700">Cancel</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

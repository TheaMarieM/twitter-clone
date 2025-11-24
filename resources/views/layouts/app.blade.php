<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tweet Tweet')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <i class="fab fa-twitter text-blue-500 text-3xl"></i>
                    <span class="text-xl font-bold hidden sm:inline">Tweet Tweet</span>
                </a>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-500 transition">
                            <i class="fas fa-home text-xl"></i>
                        </a>
                        <a href="{{ route('profile.show', auth()->user()) }}" class="flex items-center space-x-2 hover:bg-gray-100 rounded-full px-3 py-1 transition">
                            <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full">
                            <span class="font-semibold hidden sm:inline">{{ auth()->user()->name }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-semibold">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full transition">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-4xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-4xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <script>
        // Auto-dismiss flash messages
        setTimeout(() => {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);

        // Like/Unlike functionality with AJAX
        // Accepts the button element: <button data-tweet-id="..." onclick="toggleLike(this)">
        function toggleLike(el) {
            const tweetId = el.dataset.tweetId || el.getAttribute('data-tweet-id');
            const button = el;

            if (!tweetId) return;

            fetch(`/tweets/${tweetId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const icon = button.querySelector('i');
                const count = button.querySelector('.likes-count');

                if (data.liked) {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-red-500');
                } else {
                    icon.classList.remove('fas', 'text-red-500');
                    icon.classList.add('far');
                }

                if (count) {
                    count.textContent = data.likes_count;
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Character counter for tweet form
        function updateCharCount(textarea) {
            const maxLength = 280;
            const currentLength = textarea.value.length;
            const counter = document.getElementById('char-count');
            const submitBtn = document.getElementById('tweet-submit');
            
            counter.textContent = `${currentLength}/${maxLength}`;
            
            if (currentLength > maxLength) {
                counter.classList.add('text-red-500');
                counter.classList.remove('text-gray-500');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                counter.classList.remove('text-red-500');
                counter.classList.add('text-gray-500');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // Delete confirmation
        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this tweet? This action cannot be undone.')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel News') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
<header class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4 bg-white shadow-md px-6">
            <!-- Logo -->
            <div class="flex items-center space-x-4">
                <a href="/" class="text-2xl font-bold text-blue-600">Laravel News</a>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>

                <!-- Dropdown for Categories -->
                <div class="relative">
                    <!-- Dropdown Trigger -->
                    <button
                        id="dropdownButton"
                        class="text-gray-700 hover:text-blue-600 font-medium flex items-center space-x-1">
                        <span>Categories</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div
                        id="dropdownMenu"
                        class="absolute hidden bg-white shadow-lg rounded-md mt-2 z-10 w-48">
                        <ul class="text-gray-700">
                            @foreach ($cats as $cat)
                                <li>
                                    <a href="{{ route('category', ['id' => $cat->id]) }}"
                                       class="block px-4 py-2 hover:bg-blue-100">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">About Us</a>
                <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
            </nav>

            <!-- Right Side -->
            <div class="hidden md:flex items-center space-x-4">
                @if(Auth::check())
                    @if(Auth::user()->is_admin === 1)
                        <a href="{{ route('adminDashboard') }}" class="block text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-blue-600 font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 font-medium">Register</a>
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuButton" class="md:hidden text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <nav id="mobileMenu" class="hidden md:hidden space-y-4">
            <a href="/" class="block text-gray-700 hover:text-blue-600">Home</a>
            <div class="relative">
                <!-- Dropdown Trigger -->
                <button id="mobileDropdownButton" class="text-gray-700 hover:text-blue-600 flex items-center">
                    Categories
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div
                    id="mobileDropdownMenu"
                    class="absolute hidden bg-white shadow-lg rounded-md mt-2 z-10 w-48">
                    <ul class="text-gray-700">
                        @foreach ($cats as $cat)
                            <li>
                                <a href="{{ route('category', ['id' => $cat->id]) }}"
                                   class="block px-4 py-2 hover:bg-blue-100">{{ $cat->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <a href="#" class="block text-gray-700 hover:text-blue-600">About</a>
            <a href="#" class="block text-gray-700 hover:text-blue-600">Contact</a>
            <div id="mobileAuth" class="space-y-4">
                @if(Auth::check())
                    @if(Auth::user()->is_admin === 1)
                        <a href="{{ route('adminDashboard') }}" class="block text-gray-700 hover:text-blue-600">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left text-gray-700 hover:text-blue-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="block text-gray-700 hover:text-blue-600">Register</a>
                @endif
            </div>
        </nav>
    </div>
</header>

<!-- Main Content -->
<main class="container mx-auto px-4 py-6">
    @yield('content')
</main>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        /* Mobile menu */
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        /* Desktop Dropdown */
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            dropdownMenu.classList.add('hidden');
        });

        /* Mobile Dropdown */
        const mobileDropdownButton = document.getElementById('mobileDropdownButton');
        const mobileDropdownMenu = document.getElementById('mobileDropdownMenu');

        mobileDropdownButton.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileDropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            mobileDropdownMenu.classList.add('hidden');
        });
    });
</script>
</html>

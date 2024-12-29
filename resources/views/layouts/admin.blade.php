<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Панел</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
<div class="flex">
    <!-- Ляво странично меню -->
    <div class="w-64 bg-gray-800 text-white h-screen p-4">
        <h2 class="text-2xl font-semibold mb-6">Админ Панел</h2>
        <ul>
            <li class="mb-4">
                <a href="{{ route('home') }}" class="text-white hover:bg-gray-700 p-2 rounded">Към сайта</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('adminDashboard') }}" class="text-white hover:bg-gray-700 p-2 rounded">Главна</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('categories.index') }}" class="text-white hover:bg-gray-700 p-2 rounded">Категории</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('comments.index') }}" class="text-white hover:bg-gray-700 p-2 rounded">Коментари</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('news.index') }}" class="text-white hover:bg-gray-700 p-2 rounded">Новини</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('users.index') }}" class="text-white hover:bg-gray-700 p-2 rounded">Потребители</a>
            </li>
            <li class="mb-4">
                <a href="{{ route('pulls.index') }}" class="text-white hover:bg-gray-700 p-2 rounded">Pulls</a>
            </li>
            <hr class="mb-5"/>
            <h2 class="text-xl font-semibold mb-6">Потребителски Панел</h2>
            <div class="relative">
            <button
                id="profileDropdownButton"
                class="flex items-center space-x-2 focus:outline-none"
            >
                <img src="https://via.placeholder.com/32" alt="Profile" class="w-8 h-8 rounded-full">
                @if(Auth::check())
                    <span class="text-gray-100">{{ Auth::user()->name }}</span>
                @else
                    <span class="text-gray-100">Guest</span>
                @endif
            </button>
            @if(Auth::check())
                <div
                    id="profileDropdownMenu"
                    class="absolute right-0 mt-2 bg-white shadow-md rounded border w-48 hidden"
                >
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
        @endif
    </div>
        </ul>
    </div>

    <!-- Основно съдържание -->
    <div class="flex-1 p-6">
        @yield('content')
    </div>
</div>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</body>
</html>

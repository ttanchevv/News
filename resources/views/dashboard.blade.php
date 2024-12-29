@extends('layouts.admin')

@section('content')
    <!-- Ред с карти за статистиката -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Карта за броя новини -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700">Брой новини</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $newsCount }}</p>
        </div>

        <!-- Карта за броя потребители -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700">Брой потребители</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $usersCount }}</p>
        </div>

        <!-- Карта за последния потребител -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700">Последен потребител</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $lastUser }}</p>
        </div>

        <!-- Карта за последната новина -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700">Последна новина</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $lastNewsTitle }}</p>
        </div>
    </div>

@endsection

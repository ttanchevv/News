@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="bg-gray-100 min-h-screen p-8">
        <h1 class="text-3xl font-bold mb-8 text-center">Edit User</h1>
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-gray-700 font-medium">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>
            <div>
                <label for="is_admin" class="block text-gray-700 font-medium">Role</label>
                <select name="is_admin" id="is_admin"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>Потребител</option>
                    <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Админ</option>
                    <option value="2" {{ $user->is_admin == 2 ? 'selected' : '' }}>Модератор</option>
                </select>
            </div>
            <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                Update User
            </button>
        </form>
    </div>
@endsection

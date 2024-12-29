@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-6">Manage Categories</h1>

        <!-- Success message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Category Section -->
        <div class="w-full mb-6">
            <h2 class="text-xl font-semibold mb-4">Add New Category</h2>
            <form action="{{ route('createCats') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add Category</button>
            </form>
        </div>

        <!-- Edit Category Section -->
        @isset($category)
            <div class="w-full mb-6">
                <h2 class="text-xl font-semibold mb-4">Edit Category</h2>
                <form action="{{ route('updateCats', ['id' => $category->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700">Select Category to Edit</label>
                        <select name="category_id" id="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="" disabled selected>Select a category</option>
                            @foreach($getCats as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $category->id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="edit_name" class="block text-sm font-medium text-gray-700">New Category Name</label>
                        <input type="text" name="name" id="edit_name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="New name" required>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Update Category</button>
                </form>
            </div>
        @endisset

        <!-- Existing Categories List -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-4">Existing Categories</h2>
            <table class="w-full bg-white border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Category Name</th>
                    <th class="border px-4 py-2 text-left">Created At</th>
                    <th class="border px-4 py-2 text-left">Last Edit</th>
                    <th class="border px-4 py-2 text-left">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($getCats as $category)
                    <tr>
                        <td class="border px-4 py-2">{{ $category->id }}</td>
                        <td class="border px-4 py-2">{{ $category->name }}</td>
                        <td class="border px-4 py-2">{{ $category->created_at }}</td>
                        <td class="border px-4 py-2">{{ $category->updated_at }}</td>
                        <td>
                            <form action="{{ route('deleteCat', ['id' => $category->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border px-4 py-2 text-red-700">Delete</button>
                            </form>
                            <form action="{{ route('editCats', ['id' => $category->id]) }}" method="GET">
                                <button type="submit" class="border px-4 py-2 text-blue-700">Edit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

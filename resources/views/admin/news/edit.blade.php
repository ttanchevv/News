@extends('layouts.admin')

@section('title', 'Edit News')

@section('content')
    <div class="bg-white shadow rounded p-6">
        <h1 class="text-2xl font-bold mb-6">Edit News</h1>

        <form action="{{ route('updateNews', ['id' => $newsByID->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $newsByID->title) }}" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Content -->
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-medium mb-2">Content</label>
                <textarea id="content" name="content" rows="6" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $newsByID->content) }}</textarea>
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                <select name="category_id" id="category_id" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $newsByID->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="news_img" class="block text-gray-700 font-medium mb-2">Image</label>
                <input type="file" name="news_img" id="news_img" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @if ($newsByID->news_img)
                    <div class="mt-2">
                        <img src="{{ asset('images/news/' . $newsByID->news_img) }}" alt="Current Image" width="100">
                    </div>
                @endif
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200">
                Update News
            </button>
        </form>
    </div>
@endsection

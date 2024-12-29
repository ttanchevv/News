@extends('layouts.admin')

@section('title', 'Manage News')

@section('content')
    <div class="bg-white rounded-2xl p-6 shadow-2xl">
        <h1 class="text-2xl font-bold mb-6">Manage News</h1>

        <!-- Form to create new news -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Create New News</h2>
            <form action="{{ route('createNews') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea type="text" name="content" id="content" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>
                <div class="mb-4">
                    <label for="news_img" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="news_img" id="news_img" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <!-- Assuming categories are passed to the view -->
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create News</button>
            </form>
        </div>

        <!-- News List -->
        @if($news->isEmpty())
            <p class="text-red-700 text-center font-extrabold">No news available. Please create one above.</p>
        @else
            <div>
                <h2 class="text-xl font-semibold mb-4">Existing News</h2>
                <table class="w-full bg-white border-collapse rounded-2xl shadow-2xl">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Pic</th>
                        <th class="border px-4 py-2 text-left">Title</th>
                        <th class="border px-4 py-2 text-left">Created At</th>
                        <th class="border px-4 py-2 text-left">Category</th>
                        <th class="border px-4 py-2 text-left">User</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($news as $article)
                        <tr>
                            <td class="border px-4 py-2">{{ $article->id }}</td>
                            <td class="border px-4 py-2"><img class="object-scale-down h-25 w-48" src="{{ asset('images/news/'.$article->news_img) }}"  alt="News Image"/></td>
                            <td class="border px-4 py-2">{{ $article->title }}</td>
                            <td class="border px-4 py-2">{{ $article->created_at }}</td>
                            <td class="border px-4 py-2"> <a href="{{ route('categories.index') }}">{{ $article->category->name }}</a></td>
                            <td class="border px-4 py-2"><a href="#">{{ $article->users?->name }}</a></td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('editNews', ['id' => $article->id]) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('deleteNews', ['id' => $article->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-4">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

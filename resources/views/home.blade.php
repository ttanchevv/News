@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
@endphp

@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="flex flex-wrap lg:flex-nowrap gap-6">
        <!-- Latest News -->
        <div class="flex-1 bg-white shadow-md rounded p-4">
            <h2 class="text-xl font-bold mb-4">Latest News</h2>
            <div class="space-y-6">
                @foreach($news as $item)
                    <div class="flex items-center space-x-6 border-2 news-card bg-white rounded-lg p-4 shadow-lg">
                        <!-- Image Section -->
                        <div class="w-1/3">
                            <img src="{{ asset('images/news/'.$item->news_img) }}" alt="News Image" class="object-cover w-full h-full rounded-lg">
                        </div>
                        <!-- Text Section -->
                        <div class="w-2/3">
                            <!-- Title -->
                            <h3 class="text-xl font-semibold text-gray-800">
                                <a href="{{ route('article', ['id' => $item->id])}}">{{ Str::limit($item->title, 40) }}</a>
                            </h3>
                            <!-- Content -->
                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($item->content, 100) }}</p>

                            <!-- Additional Info Below -->
                            <div class="text-xs text-gray-700 mt-3">
                                <p>
                                    Автор: <a href="#" class="text-blue-500">{{ $item->users?->name }}</a> |
                                    Дата: {{ Carbon::parse($item->created_at)->diffForHumans() }} |
                                    Коментари: <a href="{{ route('article', ['id' => $item->id]) }}" class="text-blue-500">{{ $item->comments_count }}</a> |
                                    Преглеждания: {{ $item->views }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{$news->links('pagination::tailwind')}}
            </div>
        </div>

        <!-- Sidebar -->
        @include('layouts.sidebar', ['mostRead' => $mostRead, 'mostCommented' => $mostCommented, 'cats' => $cats])
    </div>
@endsection

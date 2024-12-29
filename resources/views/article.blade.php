@php
    use Carbon\Carbon;
@endphp

@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <div class="flex flex-col">
        <div class="container mx-auto px-4">
            <!-- Навигация (Breadcrumb) -->
            <nav class="text-gray-700 text-sm mb-4 ml-0">
                <a href="{{ route('home') }}" class="text-blue-500 hover:no-underline">Home</a>
                &rarr;
                <a href="{{ route('category', ['id' => $cat->id]) }}" class="text-blue-500 hover:no-underline">{{ $cat->name }}</a>
                &rarr;
                <span class="text-gray-600">{{ $news->title }}</span>
            </nav>
        </div>
    </div>
    <div class="flex flex-wrap lg:flex-nowrap gap-6">
        <div class="flex-1 bg-white shadow-md rounded p-4">
            <div class="space-y-6">
                <div class="bg-white py-8 -mb-10">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $news->title }}</h1>
                    <div class="text-xs text-gray-700 mt-3">
                        <p>
                            Автор: <a href="#" class="text-blue-500">{{ $news->users?->name }}</a> |
                            Дата: {{ Carbon::parse($news->created_at)->diffForHumans() }} |
                            Коментари: <a href="#comments" class="text-blue-500">{{ $commentsCount }}</a> |
                            Преглеждания: {{ $news->views }}
                        </p>
                    </div>
                </div>
                <div class="w-full md:w-4/4 px-4">
                    <img src="{{ asset('images/news/'.$news->news_img) }}" alt="Blog Featured Image" class="float-left w-1/5 mr-2">
                    <div class="prose max-w-none">
                        <p>{{ $news->content }}</p>
                    </div>
                    <!-- Add Comment Form -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Добави коментар</h2>
                        @auth
                            <form action="{{ route('comments.store', $news->id) }}" method="POST">
                                @csrf
                                <textarea class="mt-1 block w-full border-gray-300 rounded-md shadow-md" name="comment" rows="5" placeholder="Напишете коментар..." required></textarea>
                                <button type="submit" class="mt-3 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create News</button>
                            </form>
                        @else
                            <p class="text-gray-600">Трябва да сте <a href="{{ route('login') }}" class="text-blue-500">влезли в профила си</a>, за да оставите коментар.</p>
                        @endauth
                    </div>
                    <!-- Comments Section -->
                    <div id="comments" class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Коментари</h2>
                        @if($comments->isEmpty())
                            <p class="text-gray-600">Няма коментари за тази новина. Бъди първият, който ще остави коментар!</p>
                        @else
                            <ul class="space-y-4">
                                @foreach($comments as $comment)
                                    <li class="border-b pb-4">
                                        <p class="text-gray-800 font-semibold">{{ $comment->user->name ?? 'Анонимен' }}</p>
                                        <p class="text-gray-600 text-sm">{{ Carbon::parse($comment->created_at)->toDateTimeString() }}</p>
                                        <p class="mt-2 break-words border-b-cyan-900 shadow-2xl text-gray-800">{{ $comment->comment }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.sidebar', ['mostRead' => $mostRead, 'mostCommented' => $mostCommented, 'cats' => $cats])
    </div>
@endsection

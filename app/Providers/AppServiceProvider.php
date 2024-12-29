<?php

namespace App\Providers;

use App\Models\News;
use App\Models\Poll;
use App\Services\ViewCounterService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ViewCounterService::class, function ($app) {
            return new ViewCounterService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['home', 'category', 'layouts.sidebar', 'article'], function ($view) {
            $mostRead = News::orderBy('views', 'desc')->take(5)->get();
            $mostCommented = News::withCount('comments')
                ->orderBy('comments_count', 'desc')
                ->take(5)
                ->get();

            $view->with(compact('mostRead', 'mostCommented'));
        });

        // Споделяме най-новата анкета със всички изгледи
        $poll = Poll::with('options.votes')->latest()->first();

        // Споделяме променливата `$poll` с всички изгледи
        view()->share('poll', $poll);
    }
}

<?php
namespace App\Services;

use App\Models\News;
use App\Models\NewsView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewCounterService
{
    public function countView(News $news, Request $request)
    {
        // Проверка за логнат потребител
        if (auth()->check()) {
            // Логнат потребител - проверка по user_id
            $exists = DB::table('news_views')
                ->where('news_id', $news->id)
                ->where('user_id', auth()->id())
                ->exists();

            if (!$exists) {
                DB::table('news_views')->insert([
                    'news_id' => $news->id,
                    'user_id' => auth()->id(),
                    'ip_address' => null, // Празно за логнати потребители
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            // Гост - проверка по IP адрес
            $ipAddress = $request->ip();

            $exists = DB::table('news_views')
                ->where('news_id', $news->id)
                ->where('ip_address', $ipAddress)
                ->exists();

            if (!$exists) {
                DB::table('news_views')->insert([
                    'news_id' => $news->id,
                    'user_id' => null, // Празно за анонимни потребители
                    'ip_address' => $ipAddress,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Увеличаваме броя на преглежданията в таблицата news
        $viewsCount = DB::table('news_views')->where('news_id', $news->id)->count();
        $news->views = $viewsCount;
        $news->save();
    }

}

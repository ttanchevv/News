<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Services\ViewCounterService; // Импортиране на класа
use App\Models\Category;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private ViewCounterService $viewCounter;

    public function __construct(ViewCounterService $viewCounter)
    {
        $this->viewCounter = $viewCounter; // Увери се, че инжектираш класа
    }

    public function homePage()
    {
        $cats = Category::all();
        $news = News::withCount('comments')->paginate(10);
        $mostRead = News::orderBy('views', 'desc')->take(5)->get();
        $results = $this->getPollResults();  // Извикваме помощния метод за резултати

        // Най-коментирани новини (сортиране по броя на коментари)
        $mostCommented = News::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('news', 'cats', 'mostRead', 'mostCommented', 'results'));
    }

    public function getPollResults()
    {
        // Вземаме последната активна анкета
        $poll = Poll::with('options.votes')->latest()->first();
        $results = [];

        if ($poll) {
            $totalVotes = $poll->votes()->count(); // Използвайте метода за броене на гласовете
            $results = $poll->options->map(function ($option) use ($totalVotes) {
                $votes = $option->votes()->count(); // Използвайте метода за броене на гласовете за всяка опция
                $percentage = $totalVotes > 0 ? ($votes / $totalVotes) * 100 : 0;

                return [
                    'option_text' => $option->option_text,
                    'votes' => $votes,
                    'percentage' => $percentage,
                ];
            });
        }

        return $results;
    }

    public function article($id, Request $request)
    {
        $news = News::findOrFail($id);
        $cat = $news->category; // Вземи категорията за новината
        $cats = Category::all();
        $comments = $news->comments;

        $commentsCount = $news->comments()->count();

        // Викаме метода за броене на преглеждания
        $this->viewCounter->countView($news, $request);

        $results = $this->getPollResults();  // Извикваме помощния метод за резултати

        return view('article', compact('news', 'results', 'comments', 'commentsCount', 'cats', 'cat'));
    }

    public function category($id, Request $request)
    {
        $cats = Category::all(); // Зареждаме всички категории за менюто
        $currentCategory = Category::findOrFail($id); // Категорията, която се показва в момента
        // Странициране на новините
        $news = News::where('category_id', $id)->paginate(10);
        $results = $this->getPollResults();  // Извикваме помощния метод за резултати


        return view('category', compact('news', 'cats', 'currentCategory', 'results'));
    }


    public function adminPanel()
    {
        // Вземаме брой новини
        $newsCount = News::count();

        // Вземаме брой потребители
        $usersCount = User::count();

        // Последния регистриран потребител
        $lastUser = User::latest()->first()->name;

        // Последната новина
        $lastNews = News::latest()->first();
        if ($lastNews) {
            $lastNewsTitle = $lastNews->title;
        } else {
            $lastNewsTitle = 'No news available';
        }



        return view('dashboard', compact('lastNewsTitle', 'lastUser', 'usersCount', 'newsCount'));
    }



}

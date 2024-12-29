<?php
namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;  // Добавяме Category модел
use App\Models\NewsView;
use App\Services\ViewCounterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{

    protected ViewCounterService $viewCounter;

    public function __construct(ViewCounterService $viewCounter)
    {
        $this->viewCounter = $viewCounter;  // Свързваме класа с контролера
    }

    public function index()
    {
        $news = News::with('category', 'users')->get(); // Вземи всички новини
        $categories = Category::all(); // Вземи всички категории
        return view('admin.news', compact('news', 'categories'));
    }


    /** Views counter */
    public function show($id, Request $request)
    {
        // Намери новината по ID
        $news = News::findOrFail($id);

        // Викаме метода за броене на преглеждания
        $this->countView($news, $request);

        // Връщаме изгледа с новината
        return view('news.show', compact('news'));
    }

    public function createNews(Request $request)
    {
        // Валидиране на данните от формата
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'news_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Обработка на каченото изображение
        $imageName = time().'.'.$request->news_img->extension();
        $request->news_img->move(public_path('images/news'), $imageName);

        // Създаване на новината
        $news = News::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),  // Добавяне на съдържание
            'news_img' => $imageName,  // Запис на името на файла
            'category_id' => $request->input('category_id'),
            'user_id' => auth()->id(),  // Ако ползваш аутентикация
            'views' => 0,  // Инициализация на брояча за гледания
        ]);

        // Пренасочване след успешен запис
        return redirect()->route('news.index')->with('success', 'News created successfully!');
    }

    public function showEditForm($id)
    {
        // Намираме новината, която ще редактираме
        $newsByID = News::findOrFail($id);

        // Взимаме всички новини за списъка (ако е необходимо)
        $news = News::all(); // Това връща всички новини, ако искате да ги покажете в списък

        // Вземаме всички категории за избор в падащото меню
        $categories = Category::all();

        return view('admin.news.edit', compact('newsByID', 'categories', 'news'));  // Модифицираме изгледа
    }

    public function updateNews(Request $request, $id)
    {
        // Намираме новината по ID
        $news = News::findOrFail($id);

        // Валидация на данните
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:100',
            'category_id' => 'required|int|exists:categories,id',  // Проверка дали категорията съществува
            'news_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Разширената валидация за изображение
        ]);

        // Актуализираме новината
        // Обновяване на данни за новината
        $news->title = $request->input('title');
        $news->content = $request->input('content');
        $news->category_id = $request->input('category_id');

        $newsImgPath = $news->news_img; // Запазваме старото изображение, ако няма ново
        if ($request->hasFile('news_img')) {
            // Ако имаме ново изображение, качваме новото
            // Премахваме старото изображение от сървъра
            if ($news->news_img && Storage::exists('public/' . $news->news_img)) {
                Storage::delete('public/' . $news->news_img);
            }

            // Създаване на уникално име за изображението
            $imageName = Str::random(10) . '.' . $request->file('news_img')->getClientOriginalExtension();

            // Качване на новото изображение в storage директорията с уникално име
            $newsImgPath = $request->file('news_img')->storeAs('images/news', $imageName, 'public'); // Записваме пътя в storage/app/public/images/news
        }

        // Записваме промените
        $news->save();

        // Пренасочваме след успешно обновяване
        return redirect()->route('news.index')->with('success', 'News Updated!');
    }


    public function delete($id)
    {
        $news = News::find($id);
        if ($news) {
            $news->delete();
        }

        return redirect()->route('news.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function getCat()
    {
        // Извличаме всички категории
        $getCats = Category::all();
        return view('admin.categories', compact('getCats'));
    }

    public function creatCats(Request $request)
    {
        // Валидация на новата категория
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Създаване на нова категория
        Category::create([
            'name' => $request->name,
        ]);

        // Пренасочване след успешно добавяне на категория
        return redirect(route('categories.index'))->with('status', 'Category Added!');
    }

    public function showEditForm($id)
    {
        // Намираме категорията, която ще редактираме
        $category = Category::findOrFail($id);
        $getCats = Category::all();  // Взимаме всички категории за избор
        return view('admin.categories', compact('category', 'getCats'));
    }

    public function updateCats(Request $request, $id)
    {
        // Намираме категорията по ID
        $category = Category::findOrFail($id);

        // Валидация на името на категорията
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Актуализиране на името на категорията
        $category->name = $request->input('name');
        $category->save();

        // Пренасочване след успешно обновяване
        return redirect()->route('categories.index')->with('success', 'Category Updated!');
    }

    public function deleteCat(Request $request, $id)
    {
        // Намираме и изтриваме категорията
        $cat = Category::findOrFail($id);
        $cat->delete();

        // Пренасочване след успешното изтриване
        return redirect()->route('categories.index');
    }
}

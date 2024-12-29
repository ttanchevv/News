<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

Route::get('/', [PageController::class, 'homePage'])->name('home');
Route::get('/article/{id}', [PageController::class, 'article'])->name('article');
Route::get('/category/{id}', [PageController::class, 'category'])->name('category');
Route::post('/article/{id}', [CommentController::class, 'store'])->name('comments.store');
Route::post('/polls/{id}/vote', [PollController::class, 'vote'])->name('votePoll');





Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [PageController::class, 'adminPanel'])->name('adminDashboard');

    //Рутове за анкетите
    Route::post('/admin/pulls', [PollController::class, 'create'])->name('createPulls');
    Route::get('/admin/polls', [PollController::class, 'index'])->name('pulls.index');
    Route::put('/admin/polls/{id}', [PollController::class, 'updatePoll'])->name('updatePoll');
    Route::get('/admin/polls/{id}/edit', [PollController::class, 'showEditForm'])->name('editPulls');
    Route::delete('/admin/pulls/{id}', [PollController::class, 'delete'])->name('deletePulls');

    // Рутове за категории
    Route::get('admin/categories', [CategoriesController::class, 'getCat'])->name('categories.index');
    Route::post('admin/categories', [CategoriesController::class, 'creatCats'])->name('createCats');
    Route::get('admin/categories/{id}/edit', [CategoriesController::class, 'showEditForm'])->name('editCats');
    Route::put('admin/categories/{id}', [CategoriesController::class, 'updateCats'])->name('updateCats');
    Route::delete('admin/categories/{id}', [CategoriesController::class, 'deleteCat'])->name('deleteCat');

    // Рутове за коментари
    Route::get('/admin/comments', [CommentController::class, 'index'])->name('comments.index'); // GET за извеждане
    Route::put('/admin/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/admin/comments/{id}', [CommentController::class, 'delete'])->name('comments.delete'); // PUT за изтриване

    // Рутове за новини (тук може да добавиш конкретни контролери по-късно)
    Route::get('/admin/news', [NewsController::class, 'index'])->name('news.index');
    Route::post('/admin/news', [NewsController::class, 'createNews'])->name('createNews');
    Route::put('/admin/news/{id}', [NewsController::class, 'updateNews'])->name('updateNews');
    Route::delete('/admin/news/{id}', [NewsController::class, 'delete'])->name('deleteNews');
    Route::get('admin/news/{id}/edit', [NewsController::class, 'showEditForm'])->name('editNews');

    // Рутове за потребители (тук може да добавиш конкретни контролери по-късно)
    // Display the list of users
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    // Route for creating a user
    Route::post('/admin/users', [UserController::class, 'store'])->name('users.store');
    // Route for editing a user
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    // Route for updating a user
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('users.update');
    // Route for deleting a user
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

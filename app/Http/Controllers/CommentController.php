<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::with('user', 'news')->get(); // Вземи всички коментари
        return view('admin.comments', compact('comments')); // Върни изгледа с коментарите
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('comments.index');
    }

    public function store(Request $request, $newsId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->news_id = $newsId;

        if (auth()->check()) {
            // Ако потребителят е логнат
            $comment->user_id = auth()->id();
            $comment->ip_address = null;
        } else {
            // Ако потребителят е анонимен
            $comment->user_id = null;
            $comment->ip_address = $request->ip(); // Взимане на IP адреса на клиента
        }

        $comment->comment = $request->input('comment');
        $comment->save();

        return redirect()->route('article', ['id' => $newsId])
            ->with('success', 'Коментарът е добавен успешно!');
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json(['success' => false], 404);
        }

        $comment->comment = $request->text;
        $comment->save();

        return response()->json(['success' => true]);
    }

}

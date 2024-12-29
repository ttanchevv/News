<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    // Ако имате различно име на таблицата, го задайте тук
    protected $table = 'comments';

    // Масово присвояване на полета
    protected $fillable = [
        'comment', // Уверете се, че полето 'comment' съществува в базата данни
        'news_id',
        'user_id',
    ];

    // Ако имате допълнителни кастове за атрибути, добавете ги тук
    protected $casts = [
        'created_at' => 'datetime', // Пример за каст на атрибут
    ];
}

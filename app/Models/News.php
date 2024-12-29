<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

// Това ще позволи масово попълване на тези колони
    protected $fillable = [
        'title',
        'content',
        'news_img',
        'category_id',
        'user_id',
        'views'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');

    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'news_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function views()
    {
        return $this->hasMany(NewsView::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    use HasFactory;

    // Указваме името на таблицата
    protected $table = 'news_views';

    // Указваме кои полета могат да бъдат запълвани
    protected $fillable = [
        'news_id',
        'user_id',
        'ip_address',
    ];

    // Ако не използваш стандартните времена за създаване и актуализиране
    public $timestamps = false;
}

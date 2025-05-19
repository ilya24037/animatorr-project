<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animator extends Model
{
    use HasFactory;

    protected $table = 'animators';

    // Разрешённые к массовому заполнению поля
    protected $fillable = [
        'name',
        'age',
        'height',
        'price',
        'rating',
        'reviews_count',
        'slug',       // для URL
        'photo_folder' // имя папки с фото, например: "superman"
    ];

    // Дополнительно: получаем путь к изображению
    public function getMainImageUrlAttribute()
    {
        return asset("images/cards/{$this->photo_folder}/main.jpg");
    }

    public function getAllImageUrlsAttribute()
    {
        $images = [];

        for ($i = 1; $i <= 20; $i++) {
            $path = public_path("images/cards/{$this->photo_folder}/{$i}.jpg");
            if (file_exists($path)) {
                $images[] = asset("images/cards/{$this->photo_folder}/{$i}.jpg");
            }
        }

        return $images;
    }
}

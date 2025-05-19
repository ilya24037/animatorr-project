<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;   //  ← понадобится в мутаторе

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Массово заполняемые поля.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Скрытые поля при сериализации.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Преобразования типов.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    /**
     * ────────────────────────────────────────────────────────────────────
     *  Мутатор: всегда сохраняем e-mail в нижнем регистре
     * ────────────────────────────────────────────────────────────────────
     *
     *  ✔ Подстраховывает все места, где модель может быть сохранена,
     *    включая seed-скрипты, импорты и админ-панели.
     */
    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = Str::lower($value);
    }
}

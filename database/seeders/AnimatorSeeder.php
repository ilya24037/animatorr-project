<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animator;
use Faker\Factory as Faker;

class AnimatorSeeder extends Seeder
{
    public function run(): void
    {
        $faker   = Faker::create();
        $cities  = ['Москва', 'Казань', 'Екатеринбург', 'Санкт-Петербург', 'Новосибирск', 'Пермь'];

        foreach ($cities as $city) {
            // по 50 анкет на каждый город
            for ($i = 0; $i < 50; $i++) {
                Animator::create([
                    'user_id'        => 1,                           // при необходимости привяжите к реальному пользователю
                    'name'           => $faker->name(),
                    'age'            => rand(20, 40),
                    'height'         => rand(160, 190),
                    'weight'         => rand(50, 90),
                    'price'          => rand(2000, 8000),
                    'rating'         => round(rand(40, 50) / 10, 1),
                    'reviews_count'  => rand(10, 200),              // 👈 правильное поле
                    'city'           => $city,
                    'type'           => $faker->randomElement(['solo', 'team']), // 👈 допустимые значения enum
                    'photo_folder'   => 'default',                  // 👈 вместо image
                    'slug'           => $faker->unique()->slug,     // пригодится для SEO-URL
                    'is_online'      => $faker->boolean(30),
                    'is_verified'    => $faker->boolean(20),
                ]);
            }
        }
    }
}

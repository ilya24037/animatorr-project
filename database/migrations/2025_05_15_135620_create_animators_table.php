<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Основная информация
            $table->string('name');
            $table->unsignedTinyInteger('age');
            $table->unsignedTinyInteger('height');
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('city', 64)->index();
            $table->text('about')->nullable();

            // Коммерция и рейтинг
            $table->decimal('price', 10, 2)->nullable()->index();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('reviews_count')->default(0);

            // Медиа и SEO
            $table->string('photo_folder')->nullable();
            $table->string('slug')->unique();

            // Статусы
            $table->boolean('is_online')->default(false)->index();
            $table->boolean('is_verified')->default(false)->index();
            $table->enum('type', ['solo', 'team'])->default('solo')->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animators');
    }
};

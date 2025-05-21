<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Duplicate-safe ads table migration.
 */
return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('ads')) {
            Schema::create('ads', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ads')) {
            Schema::dropIfExists('ads');
        }
    }
};

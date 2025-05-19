<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animators', function (Blueprint $table) {
            $table->timestamp('bumped_at')->nullable()->index()
                  ->comment('Дата последнего поднятия объявления');
            $table->timestamp('highlight_until')->nullable()->index()
                  ->comment('Период действия платного «Выделить»');
        });
    }

    public function down(): void
    {
        Schema::table('animators', function (Blueprint $table) {
            $table->dropColumn(['bumped_at', 'highlight_until']);
        });
    }
};

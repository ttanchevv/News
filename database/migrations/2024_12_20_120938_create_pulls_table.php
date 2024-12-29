<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id(); // Уникален идентификатор
            $table->string('title'); // Заглавие на анкетата
            $table->text('description')->nullable(); // Описание на анкетата
            $table->timestamp('start_date')->nullable(); // Начална дата
            $table->timestamp('end_date')->nullable(); // Крайна дата
            $table->boolean('is_active')->default(true); // Статус на анкетата
            $table->timestamps(); // Създадена/Обновена
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pulls');
    }
};

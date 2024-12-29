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
        Schema::create('poll_options', function (Blueprint $table) {
            $table->id(); // Уникален идентификатор
            $table->foreignId('poll_id')->constrained()->onDelete('cascade'); // Връзка с анкетата
            $table->string('option_text')->nullable(); // Текст на опцията
            $table->unsignedInteger('votes')->default(0); // Гласове за опцията
            $table->timestamps(); // Създадена/Обновена
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_options');
    }
};

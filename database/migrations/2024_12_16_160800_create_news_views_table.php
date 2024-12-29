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
        Schema::create('news_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // За логнати потребители
            $table->string('ip_address')->nullable(); // За гости (не логнати потребители)
            $table->timestamps();

            $table->unique(['news_id', 'user_id']); // Уникален запис за логнат потребител
            $table->unique(['news_id', 'ip_address']); // Уникален запис за IP адрес
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_views');
    }
};

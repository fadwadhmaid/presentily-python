<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')
                  ->constrained('sections')
                  ->onDelete('cascade');
            $table->integer('number');                      // 1, 2, 3...
            $table->string('title');                        // 'Algorithmique'
            $table->text('description')->nullable();
            $table->string('category')->nullable();         // 'Fondamentaux'
            $table->string('category_color')->default('text-brandCyber');
            $table->integer('duration')->default(30);       // minutes
            $table->integer('lessons')->default(5);         // nb leçons
            $table->integer('xp_reward')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['section_id', 'number']);
            $table->index(['section_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
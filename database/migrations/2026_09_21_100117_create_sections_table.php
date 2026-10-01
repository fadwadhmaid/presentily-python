<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();               // 'informatique', 'scientifique'
            $table->string('name');                         // 'Bac Informatique'
            $table->string('short_name');                   // 'Info', 'Sci'
            $table->text('description')->nullable();
            $table->string('color', 20)->default('#FDE047');// couleur hexa
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
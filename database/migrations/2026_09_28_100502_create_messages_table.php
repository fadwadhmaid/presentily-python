<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['avis', 'reclamation'])->default('avis');
            $table->string('subject');
            $table->text('content');
            $table->enum('status', ['en_attente', 'en_cours', 'resolu', 'ferme'])
                  ->default('en_attente');
            $table->text('admin_reply')->nullable();
            $table->foreignId('replied_by')->nullable()
                  ->constrained('users')->onDelete('set null');
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();

            // Index pour accélérer les requêtes fréquentes
            $table->index(['user_id', 'status']);
            $table->index('type');
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
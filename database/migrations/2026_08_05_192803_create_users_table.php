<?php
// database/migrations/2024_01_01_000000_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('school')->nullable();
            $table->enum('grade', ['1ere', '2eme', '3eme', '4eme', 'Bac'])->nullable();
            $table->string('governorate')->nullable();
            
            // Points et progression
            $table->integer('total_xp')->default(0);
            $table->integer('level')->default(1);
            $table->integer('current_chapter')->default(0);
            $table->integer('current_lesson')->default(0);
            $table->integer('completed_lessons')->default(0);
            $table->integer('completed_exercises')->default(0);
            
            // Streak et activité
            $table->integer('streak_days')->default(0);
            $table->timestamp('last_activity_date')->nullable();
            
            // Configuration
            $table->json('avatar_config')->nullable();
            $table->json('badges')->nullable();
            $table->json('achievements')->nullable();
            
            // Abonnement
            $table->string('subscription_type')->default('free');
            $table->timestamp('subscription_end_date')->nullable();
            $table->boolean('is_premium')->default(false);
            
            // Sécurité et vérification
            $table->string('email_verification_token')->nullable();
            $table->string('reset_password_token')->nullable();
            $table->timestamp('reset_password_expires')->nullable();
            
            // Sécurité avancée
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->json('ip_addresses')->nullable();
            $table->string('user_agent')->nullable();
            
            // Autres
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            
            // Index pour les performances
            $table->index('email');
            $table->index('email_verification_token');
            $table->index('reset_password_token');
            $table->index('last_activity_date');
            $table->index(['is_premium', 'subscription_end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
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
        Schema::create('watch_login_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('watch_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('mode')->nullable(); //WEB OR BADGE
            $table->boolean('success')->nullable();
            $table->boolean('cancel')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->timestamp('logout_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watch_login_logs');
    }
};

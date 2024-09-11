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
        Schema::create('watches', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('model')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('is_connected')->default(false); //Heartbeat to show the watch is still connected to WIFI
            $table->unsignedBigInteger('login_user_id')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->unsignedBigInteger('last_edit_user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watches');
    }
};

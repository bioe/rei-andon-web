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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('username')->unique()->nullable(); //Employee Code as well
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->nullable();
            $table->text('menus')->nullable();
            $table->string('segment_code')->nullable();
            $table->string('user_type')->nullable();
            $table->string('shift')->nullable(); //morning shift or night shift, logout at specific time
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

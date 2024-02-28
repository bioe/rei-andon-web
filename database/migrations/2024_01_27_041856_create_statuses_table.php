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
        Schema::create("statuses", function (Blueprint $table) {

            $table->id();
            $table->string('code')->unique();;
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('state')->nullable();
            $table->string('button_1')->nullable();
            $table->string('button_2')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('last_edit_user_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};

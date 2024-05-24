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
        Schema::create('robots', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('pick_oven')->default(0);
            $table->tinyInteger('put_oven')->default(0);
            $table->tinyInteger('pick_desiccator')->default(0);
            $table->tinyInteger('put_desiccator')->default(0);
            $table->integer('pick_count')->default(0);
            $table->tinyInteger('stop')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('robots');
    }
};

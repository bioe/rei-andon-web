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
        Schema::create('desiccators', function (Blueprint $table) {
            $table->id();
            $table->double('temperature')->nullable();
            $table->double('humidity')->nullable();
            $table->tinyInteger('alarm')->default(0);
            $table->tinyInteger('gas')->default(0);
            $table->tinyInteger('switch1')->default(0);
            $table->tinyInteger('switch2')->default(0);
            $table->tinyInteger('switch3')->default(0);
            $table->tinyInteger('switch4')->default(0);
            $table->tinyInteger('cylinder_top')->default(0);
            $table->tinyInteger('cylinder_bottom')->default(0);
            $table->tinyInteger('safety_curtain')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desiccators');
    }
};

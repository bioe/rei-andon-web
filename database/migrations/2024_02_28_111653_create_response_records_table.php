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
        Schema::create('response_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('employee_code')->nullable();
            $table->string('response_option')->nullabe();
            $table->integer('response_duration_second')->nullable(); //seconds taken to response
            $table->boolean('attending')->nullable(); //They use response to button_1 (GOOD)
            $table->unsignedBigInteger('status_record_id')->nullabe();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_records');
    }
};

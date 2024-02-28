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
        Schema::create('status_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->timestamp('status_date')->nullable();
            $table->string('create_employee_id')->nullable();
            $table->string('create_employee_code')->nullable();
            $table->string('response_employee_id')->nullable();
            $table->string('response_employee_code')->nullable();
            $table->string('response_option')->nullabe();
            $table->timestamp('response_at')->nullable(); //User response from watch
            $table->text('remark')->nullable();
            $table->string('segment_code')->nullabe();
            $table->string('machine_code')->nullabe();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_records');
    }
};

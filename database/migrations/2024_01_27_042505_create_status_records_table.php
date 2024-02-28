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
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('employee_code')->nullable();
            $table->text('remark')->nullable();
            $table->string('segment_code')->nullabe();
            $table->string('machine_code')->nullabe();
            $table->timestamp('attended_at')->nullable(); //When operator is infront of the machine and press "LOCAL"
            $table->integer('attend_duration_second')->nullable(); //seconds taken to attend
            $table->timestamp('resolved_at')->nullable(); //When machine turn back to GREEN
            $table->integer('resolve_duration_second')->nullable(); //seconds taken to resolve
            $table->boolean('active')->default(false);
            $table->string('origin')->nullable(); //the record is create from REI or WATCH
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

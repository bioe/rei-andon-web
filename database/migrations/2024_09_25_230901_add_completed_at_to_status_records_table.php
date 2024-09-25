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
        Schema::table('status_records', function (Blueprint $table) {
            $table->integer('complete_duration_second')->after('resolve_duration_second')->nullable(); //seconds taken to complete
            $table->timestamp('completed_at')->nullable()->after('resolve_duration_second'); //Operator update complete the task
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_records', function (Blueprint $table) {
            $table->dropColumn('completed_at');
            $table->dropColumn('complete_duration_second');
        });
    }
};

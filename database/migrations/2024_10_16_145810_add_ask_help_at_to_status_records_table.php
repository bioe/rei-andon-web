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
            $table->unsignedBigInteger('status_record_help_id')->after('complete_duration_second')->nullable(); //the original status record id
            $table->timestamp('ask_help_at')->nullable()->after('complete_duration_second'); //When the ask for help requested
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_records', function (Blueprint $table) {
            $table->dropColumn('ask_help_at');
            $table->dropColumn('status_record_help_id');
        });
    }
};

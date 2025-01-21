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
        Schema::table('watch_login_logs', function (Blueprint $table) {
            $table->boolean('poll_logout')->nullable()->after('cancel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('watch_login_logs', function (Blueprint $table) {
            $table->dropColumn('poll_logout');
        });
    }
};

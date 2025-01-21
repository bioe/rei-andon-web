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
        /**
         * From Sampson supplier:
         * "cabinetCode" is a readable and unique identifier for the current cabinet. You must input this code into the client settings and then register the terminal with the management console.
         * "boxId" is described as an inner GUID for each charging cable. However, this field is actually a string representing an internal index number for each box in the drawer, such as "1", "2", "3", etc., and not a GUID value.
         * "boxNo" is a user-readable number assigned to each charging cable. For example, '1-A' refers to the first cable in the first drawer, and '3-B' refers to the second cable in the third drawer, etc. You can customize this number as you wish.
         */
        Schema::create('cabinets', function (Blueprint $table) {
            $table->id();
            $table->string('box_id');
            $table->string('box_no');
            $table->string('status'); //"deposit" or "takeout"
            $table->unsignedBigInteger('last_operate_user_id')->nullable();
            $table->timestamp('last_occur_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabinets');
    }
};

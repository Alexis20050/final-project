<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('allocations', function (Blueprint $table) {
            // Drop foreign keys (use the correct constraint names)
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
            $table->dropForeign(['created_by']);
            
            // Drop the problematic unique indexes
            $table->dropUnique('unique_active_user_allocation');
            $table->dropUnique('unique_active_room_allocation');
            
            // Re‑add the foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('allocations', function (Blueprint $table) {
            // Drop foreign keys again
            $table->dropForeign(['user_id']);
            $table->dropForeign(['room_id']);
            $table->dropForeign(['created_by']);
            
            // Re‑add the unique indexes
            $table->unique(['user_id', 'status'], 'unique_active_user_allocation');
            $table->unique(['room_id', 'status'], 'unique_active_room_allocation');
            
            // Re‑add foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }
};
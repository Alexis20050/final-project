<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('allocations')) {
            Schema::create('allocations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('room_id')->constrained()->onDelete('cascade');
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();

                $table->unique(['user_id', 'status'], 'unique_active_user_allocation')->where('status', 'active');
                $table->unique(['room_id', 'status'], 'unique_active_room_allocation')->where('status', 'active');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('allocations');
    }
};
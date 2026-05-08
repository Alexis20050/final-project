<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            });

            // Add partial unique indexes to enforce "one active allocation" rule
            // MySQL 8+ / MariaDB 10.2+ / PostgreSQL syntax
            if (DB::getDriverName() === 'mysql') {
                DB::statement("CREATE UNIQUE INDEX unique_active_user_allocation ON allocations (user_id, status) WHERE status = 'active'");
                DB::statement("CREATE UNIQUE INDEX unique_active_room_allocation ON allocations (room_id, status) WHERE status = 'active'");
            } elseif (DB::getDriverName() === 'pgsql') {
                DB::statement("CREATE UNIQUE INDEX unique_active_user_allocation ON allocations (user_id, status) WHERE status = 'active'");
                DB::statement("CREATE UNIQUE INDEX unique_active_room_allocation ON allocations (room_id, status) WHERE status = 'active'");
            } else {
                // Fallback for SQLite (no partial indexes) – a normal unique index won't be enough,
                // but this is fine for development. In production use a supported DB.
                Schema::table('allocations', function (Blueprint $table) {
                    $table->unique(['user_id', 'status']);
                    $table->unique(['room_id', 'status']);
                });
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('allocations');
    }
};
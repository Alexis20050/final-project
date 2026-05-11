<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->string('type')->default('single');       // always single
            $table->integer('capacity')->default(1);          // always 1
            $table->decimal('price_per_month', 8, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'occupied', 'maintenance', 'archived'])
                  ->default('available');
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
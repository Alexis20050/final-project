<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Add type column if it doesn't exist
            if (!Schema::hasColumn('rooms', 'type')) {
                $table->string('type')->default('single')->after('price_per_month');
            } else {
                // Modify existing column to string with default 'single'
                $table->string('type')->default('single')->change();
            }

            // Add capacity column if it doesn't exist
            if (!Schema::hasColumn('rooms', 'capacity')) {
                $table->integer('capacity')->default(1)->after('type');
            } else {
                $table->integer('capacity')->default(1)->change();
            }

            // Add archived boolean column if missing
            if (!Schema::hasColumn('rooms', 'archived')) {
                $table->boolean('archived')->default(false)->after('status');
            }
        });

        // Update all existing rows (only if the columns exist after the above operations)
        if (Schema::hasColumn('rooms', 'type') && Schema::hasColumn('rooms', 'capacity')) {
            \DB::table('rooms')->update([
                'type'     => 'single',
                'capacity' => 1,
            ]);
        }
    }

    public function down()
    {
        // No destructive rollback – we leave the columns intact.
    }
};
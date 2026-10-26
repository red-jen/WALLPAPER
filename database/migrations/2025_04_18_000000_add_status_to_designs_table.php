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
        Schema::table('designs', function (Blueprint $table) {
            // Only add if column doesn't exist (safe for fresh + existing DBs)
            if (!Schema::hasColumn('designs', 'status')) {
                $table->string('status')->default('approved')->after('category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            if (Schema::hasColumn('designs', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};

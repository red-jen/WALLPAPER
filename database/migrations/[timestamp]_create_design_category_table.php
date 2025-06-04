<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('design_category')) {
            Schema::create('design_category', function (Blueprint $table) {
                $table->id();
                $table->foreignId('design_id')->constrained()->onDelete('cascade');
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->timestamps();

                $table->unique(['design_id', 'category_id']);
            });
        }
    }


    public function down()
    {
        Schema::dropIfExists('design_category');
    }
};

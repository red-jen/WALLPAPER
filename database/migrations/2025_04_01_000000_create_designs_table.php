<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateDesignsTable extends Migration
// {
//     public function up()
//     {
//         Schema::create('designs', function (Blueprint $table) {
//             $table->id();
//             $table->unsignedBigInteger('designer_id');
//             $table->unsignedBigInteger('category_id'); // FK to categories table
//             $table->string('title');
//             $table->string('image_path');
//             $table->timestamps();

//             $table->foreign('designer_id')->references('id')->on('users')->onDelete('cascade');
//             $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
//         });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('designs');
//     }
// }

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop tables in reverse order to avoid foreign key constraint errors
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        
        // Create tables
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('order_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('shipping', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending'); // pending, processing, completed, failed, canceled
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('artwork_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('wallpaper_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->text('description')->nullable(); // Nội dung giảm giá
            $table->enum('discount_type', ['fixed', 'percent']); // Loại giảm giá: cố định hoặc phần trăm
            $table->decimal('discount_value', 10, 2); // Giá trị giảm giá
            $table->decimal('min_order_amount', 10, 2); // Giá trị đơn hàng tối thiểu
            $table->decimal('max_discount_amount', 10, 2)->nullable(); // Giảm giá tối đa (cho trường hợp giảm theo %)
            $table->integer('usage_limit')->nullable(); // Giới hạn số lần sử dụng
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->timestamp('starts_at');
            $table->timestamp('expires_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

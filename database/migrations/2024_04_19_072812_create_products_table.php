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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên sản phẩm
            $table->text('description')->nullable(); // Mô tả sản phẩm
            $table->decimal('price', 10, 2)->nullable(); // Giá sản phẩm
            $table->integer('stock')->nullable(); // Số lượng sản phẩm trong kho
            $table->boolean('status')->default(true); // Trạng thái hoạt động của sản phẩm
            $table->unsignedBigInteger('parent_id')->nullable(); // ID của sản phẩm cha
            $table->timestamps();

            // Thiết lập khóa ngoại cho trường parent_id tham chiếu đến cùng một bảng
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

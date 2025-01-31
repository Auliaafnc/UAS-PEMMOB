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
            $table->string('name');
            $table->enum('category_product', ['analisis air', 'analisis lingkungan'])->nullable();
            $table->enum('category', ['air higiene sanitasis', 'air limbah ipal', 'analisis udara 24 jam', 'emisi pembangkit'])->nullable();
            $table->foreignId('type_product_id')->constrained('type_products')->onDelete('cascade');
            $table->foreignId('description_product_id')->nullable()->constrained('description_products')->onDelete('set null');
            $table->foreignId('parameter_id')->constrained('parameters')->onDelete('cascade');
            $table->foreignId('methode_id')->nullable()->constrained('methodes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_regulation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('regulation_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_regulation');
    }
};

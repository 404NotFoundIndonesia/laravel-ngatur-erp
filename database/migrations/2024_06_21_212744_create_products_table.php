<?php

use App\Enum\Currency;
use App\Enum\ProductStatus;
use App\Enum\Unit\Dimension;
use App\Enum\Unit\Weight;
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
            $table->string('sku')->nullable();
            $table->longText('description')->nullable();
            $table->json('specification')->nullable();

            // STATUS
            $table->string('status')->default(ProductStatus::DRAFT);

            // DIMENSION
            $table->float('height')->default(0);
            $table->float('width')->default(0);
            $table->float('length')->default(0);
            $table->string('dimension_unit')->default(Dimension::CENTIMETER);

            // WEIGHT
            $table->float('weight')->default(0);
            $table->string('weight_unit')->default(Weight::GRAM);

            // PRICE
            $table->string('currency')->default(Currency::IDR);
            $table->unsignedInteger('original_price')->default(0);
            $table->unsignedInteger('sale_price')->default(0);
            $table->unsignedInteger('production_cost')->default(0);

            $table->boolean('pre_order')->default(false);
            $table->boolean('allow_cod')->default(false);
            $table->boolean('contains_hazardous_material')->default(false);

            $table->timestamps();
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

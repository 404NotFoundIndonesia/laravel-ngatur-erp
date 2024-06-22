<?php

namespace Database\Factories;

use App\Enum\Currency;
use App\Enum\ProductStatus;
use App\Enum\Unit\Dimension;
use App\Enum\Unit\Weight;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productionCost = fake()->numberBetween(0, 15_000_000);
        $originalPrice = fake()->numberBetween($productionCost+100, $productionCost+10_000_000);
        $salePrice = fake()->numberBetween($originalPrice-1_000, $originalPrice);

        return [
            'name' => fake()->sentence(),
            'sku' => strtoupper(fake()->lexify('?????') . fake()->numerify('#####')),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(ProductStatus::cases())?->value,
            'height' => fake()->randomFloat(2, 1, 10.00),
            'width' => fake()->randomFloat(2, 1, 10.00),
            'length' => fake()->randomFloat(2, 1, 10.00),
            'dimension_unit' => fake()->randomElement(Dimension::cases())?->value,
            'weight' => fake()->randomFloat(2, 1, 10.00),
            'weight_unit' => fake()->randomElement(Weight::cases())?->value,
            'currency' => fake()->randomElement(Currency::cases())?->value,
            'original_price' => $originalPrice,
            'sale_price' => $salePrice,
            'production_cost' => $productionCost,
            'pre_order' => fake()->boolean(40),
            'allow_cod' => fake()->boolean(40),
            'contains_hazardous_material' => fake()->boolean(30),
        ];
    }
}

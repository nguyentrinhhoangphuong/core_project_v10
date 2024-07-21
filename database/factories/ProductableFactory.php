<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productable>
 */
class ProductableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productable_type = fake()->randomElement([Cart::class, Order::class]);
        $productable_id = $productable_type::query()->inRandomOrder()->value('id');
        return [
            'product_id' => Product::all()->random()->id,
            'quantity' => fake()->numberBetween(1, 10),
            'productable_type' => $productable_type,
            'productable_id' => $productable_id,
        ];
    }
}

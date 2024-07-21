<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected static $minPrice;
    protected static $maxPrice;
    protected static $usedOrderIds = [];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (!isset(self::$minPrice) || !isset(self::$maxPrice)) {
            self::$minPrice = Product::min('price');
            self::$maxPrice = Product::max('price');
        }

        $orderIds = Order::pluck('id')->toArray();
        $availableOrderIds = array_diff($orderIds, self::$usedOrderIds);

        if (empty($availableOrderIds)) {
            throw new \Exception('No more unique order IDs available.');
        }

        $orderId = fake()->randomElement($availableOrderIds);
        self::$usedOrderIds[] = $orderId;

        return [
            'amount' => fake()->randomFloat(2, self::$minPrice, self::$maxPrice),
            'order_id' => $orderId,
            'payed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

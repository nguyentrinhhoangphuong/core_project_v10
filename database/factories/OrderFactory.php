<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::whereNull('admin_since')->pluck('id');
        return [
            'status' => fake()->randomElement(['pending', 'paid', 'shipped']),
            'customer_id' => $this->faker->randomElement($users)
        ];
    }
}

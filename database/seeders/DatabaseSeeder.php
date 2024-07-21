<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Order::factory(10)->create();
        \App\Models\Cart::factory(10)->create();
        \App\Models\Productable::factory(10)->create();
        \App\Models\Payment::factory(10)->create();
    }
}

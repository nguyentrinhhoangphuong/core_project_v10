<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateCategoryProductData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-category-product-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = \App\Models\Product::all();

        foreach ($products as $product) {
            if ($product->category_product_id) {
                $product->categories()->attach($product->category_product_id);
            }
        }

        $this->info('Category data migrated successfully.');
    }
}

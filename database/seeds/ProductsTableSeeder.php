<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class,100)->create()->each(function ($product) {
            $name = $product->name;
            $product->slug = str_replace(' ','-',$name).random_int(1,10000);
            $product->save();
        });
    }
}

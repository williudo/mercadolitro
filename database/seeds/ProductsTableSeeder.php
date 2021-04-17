<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the user database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Products::class, 5)->create();
    }
}

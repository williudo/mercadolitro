<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the user database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Clients::class, 10)->create();
    }
}

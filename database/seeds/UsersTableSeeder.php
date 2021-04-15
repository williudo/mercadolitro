<?php

use Illuminate\Database\Seeder;
use  Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the user database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 5)->create();
    }
}

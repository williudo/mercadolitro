<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Clients;
use App\Models\Products;

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make('1qaz2wsx'),
        'created_at' => \Carbon\Carbon::now(),
        'id_user_created' => 0,
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Models\Products::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(25),
        'quantity' => $faker->randomNumber(2),
        'price' => $faker->randomFloat(2, 1, 10),
        'color' => $faker->randomElement(['blue', 'red', 'green', 'purple', 'yellow', 'brown', 'black', 'white', 'magenta', 'grey']),
        'id_user_created' => 0
    ];
});

$factory->define(App\Models\Clients::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'document_id' => $faker->numerify('#######'),
        'phone_number' => $faker->numerify('#######'),
        'address' => $faker->streetAddress,
        'address_number' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->state
    ];
});

$factory->define(App\Models\Orders::class, function (Faker\Generator $faker) {
    return [
        'client_id' => (Clients::all()->random(1)->first())->id,
        'product_id' => (Products::all()->random(1)->first())->id,
        'status' => 'paid',
        'date_order_paid' => $faker->dateTimeThisYear(),
    ];
});

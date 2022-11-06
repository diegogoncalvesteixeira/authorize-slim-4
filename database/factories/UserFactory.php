<?php
//

/**
 * Use $faker to add dummy attributes to model's factory
 * Example:
 * fn ($faker) => [
 *   'first_name' => $faker->firstName,
 *   'user_id' => 1, // Hard Code/Override User Id
 * ]
 */

use Illuminate\Support\Facades\Hash;
use \App\Traits\HelperTrait;

Factory::define(\App\User::class, function ($faker) {
  return [
     'name' => $faker->name,
     'email' => $faker->email,
     'password' => $faker->randomNumber(8),
     'created_at' => date('Y-m-d H:i:s'),
     'updated_at' => date('Y-m-d H:i:s'),
  ];
});
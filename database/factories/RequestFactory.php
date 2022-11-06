<?php

/**
 * Use $faker to add dummy attributes to model's factory
 * Example:
 * fn ($faker) => [
 *   'first_name' => $faker->firstName,
 *   'user_id' => 1, // Hard Code/Override User Id
 * ]
 */
Factory::define(\App\UserRequest::class, function ($faker) {
  return [
    'request' => $faker->sentence,
    'user_id' => 1, // Hard Code/Override User Id
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
  ];
});
<?php

namespace App\Traits;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait JWTTrait
{
  public function generate_token($user_email,$user_id,$user_name): string
  {
    $key = config('app.key');
    $payload = array(
      "exp" => time() + 3600,
      "iat" => time(),
      "user_email" => $user_email,
      "user_id" => $user_id,
      "user_name" => $user_name,
    );
    return JWT::encode($payload, $key,'HS256');
  }

  public function decode_token($token): array
  {
    $key = config('app.key');
    $token = str_replace('Bearer ','',$token);
    try {
      return (array) JWT::decode($token, new Key($key, 'HS256'));
    } catch (\Exception $e) {
      return ['error' => $e->getMessage()];
    }
  }
}
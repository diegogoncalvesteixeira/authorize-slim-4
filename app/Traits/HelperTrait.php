<?php

namespace App\Traits;

trait HelperTrait
{
  public function escape($string): string
  {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
  }

  public function encrypt($string): string
  {
    return openssl_encrypt($string, 'AES-128-ECB', config('app.key'));
  }

  public function decrypt($string): string
  {
    return openssl_decrypt($string, 'AES-128-ECB', config('app.key'));
  }
}
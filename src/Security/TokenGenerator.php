<?php
namespace App\Security;

final class TokenGenerator
{
  public function generate(int $bytes = 16): string
  {
    return rtrim(
      strtr(base64_encode(random_bytes($bytes)), '+/', '-_'),
      '='
    );
  }
}
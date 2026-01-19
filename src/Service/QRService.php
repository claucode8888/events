<?php
namespace App\Service;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRService
{
  public function generateQRCode(string $data): string
  {
    $qrCode = new QrCode($data);
    $pngData = (new PngWriter())->write($qrCode)->getString();
    return base64_encode($pngData);
  }
}
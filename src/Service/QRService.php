<?php
namespace App\Service;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;

class QRService
{
  public function generateQRCode(string $data, string $ext = 'png'): string
  {
    $qrCode = new QrCode($data);
    return match($ext){
      'svg' => (new SvgWriter())->write($qrCode)->getString(),
      default => (new PngWriter())->write($qrCode)->getString()
    };
  }
}
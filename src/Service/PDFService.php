<?php
namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
  public function generatePDF(string $html)
  {
    // Configuration
    $options = new Options();
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    return $dompdf->output();
  }

}